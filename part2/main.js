// Or with jQuery

$(document).ready(function () {
    const container = $("#container");
    switch (localStorage.getItem("page")) {
        case "welcome":
            loadWelcomePage();
            break;
        case "unit":
            loadUnitPage();
            break;
        case "profile":
            loadProfilePage();
            break;
        case "mycourses":
            loadMyCoursesPage();
            break;
        default:
            loadWelcomePage();
            break;
    }

    $(document).on("click", ".signup-trigger", () => {
        $("#signInModal").hide();
        $("#signUpModal").show();
    });

    $(document).on("click", ".login-trigger", () => {
        console.log("hello");
        $("#signUpModal").hide();
        $("#signInModal").show();
    });

    $(document).on("click", "#logout", () => {
        $.ajax({
            url: "api/user/signout.php",
            type: 'POST',
            success: (res) => {
                // console.log(res);
                showSnackBar(res.message);
                $("#navbar").load("./components/navbar.php");
                loadWelcomePage();
            }
        });
    });

    $(document).on("click", ".modal-close", () => {
        $("#signUpModal").hide();
        $("#signInModal").hide();
        $("#quizModal").hide();
    });

    const signInForm = $("#signInForm");
    signInForm.on("submit", (e) => {
        e.preventDefault();

        $.ajax({
            type: signInForm.attr('method'),
            url: signInForm.attr('action'),
            data: signInForm.serialize(),
            success: (res) => {
                // console.log(res);
                showSnackBar(res.message);
                if (res.message !== "Invalid Credentials") {
                    $("#signInModal").hide();
                }

                $("#navbar").load("./components/navbar.php");
                loadWelcomePage();
            }
        });
    });

    const signUpForm = $("#signUpForm");
    signUpForm.on("submit", (e) => {
        e.preventDefault();

        $.ajax({
            type: signUpForm.attr('method'),
            url: signUpForm.attr('action'),
            data: signUpForm.serialize(),
            success: (res) => {
                console.log(res);
                showSnackBar(res.message);
                if (res.message === "Account Created") {
                    $("#signUpModal").hide();
                }


            }
        });
    });

    $(document).on("click", "#profile", (e) => {
        e.preventDefault();

        loadProfilePage();

    });

    $(document).on("click", "#mycourses", (e) => {
        e.preventDefault();

        loadMyCoursesPage();

    });

    $(document).on("click", ".logo a", (e) => {
        e.preventDefault();

        loadWelcomePage();

    });

    $(document).on("submit", "#updateUsername", (e) => {
        e.preventDefault();

        const updateUsername = $("#updateUsername");
        console.log(updateUsername.attr('method'));
        console.log(updateUsername.attr('action'));
        $.ajax({
            type: updateUsername.attr('method'),
            url: updateUsername.attr('action'),
            data: updateUsername.serialize(),
            success: (res) => {
                // console.log(res.message);
                showSnackBar(res.message);
                loadProfilePage();
            }
        });



    });


    $(document).on("submit", "#updatePassword", (e) => {
        e.preventDefault();

        const updatePass = $("#updatePassword");

        $.ajax({
            type: updatePass.attr('method'),
            url: updatePass.attr('action'),
            data: updatePass.serialize(),
            success: (res) => {
                // console.log(res.message);
                showSnackBar(res.message);
                loadProfilePage();
            }
        });
    });

    $(document).on("submit", "#quizSubmission", (e) => {
        e.preventDefault();

        const quizSubmission = $("#quizSubmission");
        let correctCount = 0;
        $(`span`, "#quizSubmission").css('color', '');
        $.ajax({
            type: quizSubmission.attr('method'),
            url: quizSubmission.attr('action'),
            data: { quizId: $("#quizIdInput").val() },
            success: (res) => {
                // console.log(res.message);
                res.data && res.data.forEach((i) => {
                    console.log($(`input[name="${i.question_id}"]:checked`, '#quizSubmission').attr('id'));
                    if ($(`input[name="${i.question_id}"]:checked`, '#quizSubmission').attr('id') === i.answer_id) {
                        $(`#text-${i.answer_id}`).css('color', 'green');
                        correctCount++;
                    } else {
                        const id = $(`input[name="${i.question_id}"]:checked`, '#quizSubmission').attr('id');
                        $(`#text-${i.answer_id}`).css('color', 'green');
                        $(`#text-${id}`).css('color', 'red');

                    }
                });
                $("#numCorrect").html("<b>Correct answers: </b> " + correctCount);
                $("#numQues").html("<b>Number of questions: </b> " + $("#numQuestions").val());
                $("#percCorrect").html("<b>Percentage: </b>" + (correctCount / parseInt($("#numQuestions").val()) * 100).toFixed(2));
            }
        });
    });





    function showSnackBar(msg = "") {
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");

        // Add the "show" class to DIV
        x.innerHTML = msg;
        x.className = "show";

        // After 3 seconds, remove the show class from DIV
        setTimeout(function () { x.className = x.className.replace("show", ""); }, 2000);
    }

    function loadAvailableCourses() {
        $.ajax({
            url: "api/course/available.php",
            type: 'GET',
            success: (res) => {
                console.log(res);
                let content = '';

                if (res.message === "No courses available") {
                    showSnackBar(res.message);
                    return;
                }
                res.data && res.data.forEach((i) => {
                    content += `
                    <tr>
                        <td>${i.unit_id}</td>
                        <td>${i.unit_name}</td>
                        <td><button id="btn${i.unit_id}" class="btn">${(i.enrolled) ? "Open Course" : "Enroll"}</button></td>
                    </tr>
                    `
                    $(document).on("click", `#btn${i.unit_id}`, (e) => {
                        const action = $(`#btn${i.unit_id}`).html();
                        const unit_id = i.unit_id;
                        if (action === "Enroll") {
                            $.ajax({
                                url: "api/course/enroll.php",
                                type: 'POST',
                                data: { unitId: unit_id },
                                success: (res) => {
                                    if (res.message) {
                                        showSnackBar(res.message);
                                    }
                                    loadAvailableCourses();

                                }
                            });
                        } else if (action === "Open Course") {
                            $.ajax({
                                url: "api/course/open.php",
                                type: 'POST',
                                data: { unitId: unit_id },
                                success: (res) => {
                                    if (res.message) {
                                        showSnackBar(res.message);
                                    }
                                    loadUnitPage();

                                }
                            });

                        }

                    });
                });
                $("#availableCourses").html(content);

            }
        });
    }


    function loadMyCourses() {
        $.ajax({
            url: "api/course/available.php",
            type: 'GET',
            success: (res) => {
                console.log(res);
                let content = '';

                if (res.message === "No courses available") {
                    showSnackBar(res.message);
                    return;
                }
                res.data && res.data.forEach((i) => {
                    if (i.enrolled) {
                        content += `
                        <tr>
                            <td>${i.unit_id}</td>
                            <td>${i.unit_name}</td>
                            <td><button id="btn${i.unit_id}" class="btn">${(i.enrolled) ? "Open Course" : "Enroll"}</button></td>
                        </tr>
                        `;
                    }

                    $(document).on("click", `#btn${i.unit_id}`, (e) => {

                        const action = $(`#btn${i.unit_id}`).html();
                        const unit_id = i.unit_id;
                        if (action === "Open Course") {
                            $.ajax({
                                url: "api/course/open.php",
                                type: 'POST',
                                data: { unitId: unit_id },
                                success: (res) => {
                                    if (res.message) {
                                        showSnackBar(res.message);
                                    }
                                    loadUnitPage();

                                }
                            });

                        }

                    });
                });
                $("#myCourses").html(content);

            }
        });
    }

    function loadUnitPage() {
        container.load("./components/unit.php", () => {
            localStorage.setItem('page', 'unit');
            $(document).on("click", "#quizBtn", (e) => {
                e.preventDefault();
                // reset quiz when opening

                $("#quizModal").show();

            });

        });
    }

    function loadProfilePage() {
        container.load("./components/profile.php", () => {
            localStorage.setItem('page', 'profile');
            return;
        });
    }

    function loadWelcomePage() {
        container.load("./components/welcome.php", () => {
            localStorage.setItem('page', 'welcome');
            loadAvailableCourses();
        });
    }

    function loadMyCoursesPage() {
        container.load("./components/mycourses.php", () => {
            localStorage.setItem('page', 'mycourses');
            loadMyCourses();
        });
    }

});
