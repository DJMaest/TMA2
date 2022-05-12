<?php
include_once '../helper/session.php';
include_once '../config/Database.php';
include_once '../models/Unit.php';
include_once '../models/Topic.php';
include_once '../models/SubTopic.php';
include_once '../models/Summary.php';
include_once '../models/Quiz.php';
$database = new Database();
$db = $database->connect();
$unit = new Unit($db);

$result = $unit->getUnit($_SESSION["unitId"]);
$row = $result->fetch(PDO::FETCH_ASSOC);

extract($row);

function parseContent($content)
{
    $content = preg_replace('/<paragraph>/', '<p>', $content);
    $content = preg_replace('/<\/\s?paragraph>/', '</p>', $content);
    $content = preg_replace('/<reference url="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})">/', '<a href="$1">', $content);
    $content = preg_replace('/<\/\s?reference>/', '</a>', $content);
    $content = preg_replace('/<image source="(.+)" description="(.*)"\s?\/>/', '<img src="$1" alt="$2" />', $content);
    $content = preg_replace('/<bulletlist>/', '<ul>', $content);
    $content = preg_replace('/<\/\s?bulletlist>/', '</ul>', $content);
    $content = preg_replace('/<item>/', '<li>', $content);
    $content = preg_replace('/<\/\s?item>/', '</li>', $content);
    return $content;
}
?>
<div style="width:80%; margin:10px auto;height:700px;overflow-y:scroll;border:1px solid black;padding:10px;">
    <h1> <?php echo $unit_name ?> </h1>

    <?php
    $unit_intro = preg_replace('/<paragraph>/', '<p>', $unit_intro);
    $unit_intro = preg_replace('/<\/\s?paragraph>/', '</p>', $unit_intro);
    echo $unit_intro;
    ?>

    <div style="text-align:left;">
        <?php
        $topic = new Topic($db);
        $result = $topic->getUnitTopics($_SESSION["unitId"]);
        $subTopic = new SubTopic($db);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<h2> $topic_name </h2>";
            if ($topic_name == "Summary") {
            }
            echo "<h3> Introduction </h3>";
            $topic_intro = preg_replace('/<paragraph>/', '<p>', $topic_intro);
            $topic_intro = preg_replace('/<\/\s?paragraph>/', '</p>', $topic_intro);
            echo $topic_intro;

            $subTopics = $subTopic->getSubTopics($topic_id);

            while ($subTopicRow = $subTopics->fetch(PDO::FETCH_ASSOC)) {
                extract($subTopicRow);
                echo "<h3> $subtopic_name </h3>";

                $content = parseContent($content);

                echo "$content";
            }
        }
        $summary = new Summary($db);
        $result = $summary->getSummary($_SESSION["unitId"]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $content = parseContent($content);
        echo "<h2>Summary</h2>";
        echo "$content";
        ?>
    </div>

    <button id="quizBtn" class="btn quiz-btn">Start Quiz</button>
</div>
<div id="quizModal" class="modal">
    <div style="height:710px;" class="modal-content center">
        <h3 class="modal-close">&#10005;</h3>

        <form id="quizSubmission" method="POST" action="api/course/markquiz.php">
            <div style="height:550px;overflow-y:scroll;text-align:left;">
                <h3>Quiz for <?php echo $unit_name ?></h3>
                <br>

                <?php
                $quiz = new Quiz($db);
                $result = $quiz->getQuiz($_SESSION["unitId"]);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                extract($row);
                echo "<input id='quizIdInput' name ='quizId' type='text' value='$quiz_id' hidden>";

                $result = $quiz->getQuestions($quiz_id);
                $numQues = $result->rowCount();
                echo "<input id='numQuestions' name ='numQues' type='text' value='$numQues' hidden>";
                $index = 1;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<p>Question $index. $content</p>";
                    $answers = $quiz->getAnswers($question_id);

                    while ($ansRow = $answers->fetch(PDO::FETCH_ASSOC)) {
                        extract($ansRow);
                        $isCorrect = ($iscorrect == 0) ? "incorrect" : "correct";
                        echo "<input id='$answer_id' type='radio' name='$question_id' value='$content'/> <span id='text-$answer_id'>$content</span><br>";
                    }
                    $index++;
                }

                ?>
            </div>

            <input style="margin:5px auto;" type="submit" id="submitQuiz" class="btn" value="Submit Quiz">
            <p id="numCorrect"><b>Correct answers: </b>Not submitted</p>
            <p id="numQues"><b>Total questions: </b>Not submitted</p>
            <p id="percCorrect"><b>Percentage: </b>Not submitted</p>

    </div>


</div>