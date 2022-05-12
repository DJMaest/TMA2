<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
header('Access-Control-Allow-Origin: *');

include_once '../../config/Database.php';

// Create connection
try {
    $db = new Database();
    $conn = $db->connect();
} catch (Exception $e) {

    die("Issue with connection");
}

if (isset($_FILES['File'])) {

    $file = $_FILES['File']['tmp_name'];

    $xml = simplexml_load_file($file) or die("Err: Cannot create XML object");

    foreach ($xml->unit as $unit) {
        uploadUnit($conn, $unit);
    }
    echo "unit(s) added!";
    return FALSE;
}

function getChildElemString(SimpleXMLElement $node)
{
    $children = "";
    foreach ($node->children() as $c)
        $children = "{$children}{$c->asXML()}";

    return $children;
}

function uploadUnit($conn, $unit)
{
    $name = $unit['name'];
    $intro = getChildElemString($unit->intro);
    $query = "INSERT INTO Units (unit_name, unit_intro) VALUES ('$name', '$intro')";

    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $intro]);
    $unitId = $conn->lastInsertId();
    foreach ($unit->topic as $topic)
        uploadTopic($conn, $topic, $unitId);

    uploadSummary($conn, $unit->summary, $unitId);
    uploadQuiz($conn, $unit->quiz, $unitId);
}

function uploadTopic($conn, $topic, $unitId)
{
    echo "Inserting topic for UnitID: {$unitId}\r\n";
    $name = $topic['name'];
    $intro = getChildElemString($topic->intro);
    $query = "INSERT INTO Topics (topic_name, topic_intro, unit_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $intro, $unitId]);
    $topicId = $conn->lastInsertId();

    foreach ($topic->subtopic as $subtopic)
        uploadSubTopic($conn, $subtopic, $topicId);
}


function uploadSubTopic($conn, $subtopic, $topicId)
{
    echo "Inserting subtopic for TopicID: {$topicId}\r\n";
    $name = $subtopic['name'];
    $content = getChildElemString($subtopic);
    $query = "INSERT INTO SubTopics (subtopic_name, content, topic_id) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $content, $topicId]);
}

function uploadSummary($conn, $summary, $unitId)
{
    $content = getChildElemString($summary);
    $query = "INSERT INTO Summaries (unit_id,content) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$unitId, $content]);
}

function uploadQuiz($conn, $quiz, $unitId)
{
    $title = $quiz['title'];
    $query = "INSERT INTO Quizzes (quiz_title, unit_id) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $unitId]);
    $quizId = $conn->lastInsertId();

    foreach ($quiz->question as $ques)
        uploadQuestion($conn, $ques, $quizId);
}
function uploadAnswer($conn, $ans, $quesId)
{
    $text = $ans;
    $status = $ans['correct'] == "true" ? 1 : 0;
    $query = "INSERT INTO Answers (content, iscorrect, question_id) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$text, $status, $quesId]);
}

function uploadQuestion($conn, $ques, $quizId)
{
    $text = $ques['text'];
    $query = "INSERT INTO Questions (content, quiz_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$text, $quizId]);
    $quesId = $conn->lastInsertId();
    foreach ($ques->ans as $ans)
        uploadAnswer($conn, $ans, $quesId);
}
