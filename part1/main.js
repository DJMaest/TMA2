// Or with jQuery

$(document).ready(function () {
    $.support.cors = true;
    const container = $("#container");
    switch (localStorage.getItem("page")) {
        case "welcome":
            loadWelcomePage();
            break;

        case "profile":
            loadProfilePage();
            break;
        case "mybookmarks":
            loadMyBookMarksPage();
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
                console.log(res);
                showSnackBar(res.message);
                $("#navbar").load("./components/navbar.php");
                loadWelcomePage();
            }
        });
    });

    $(document).on("click", ".logo a", (e) => {
        e.preventDefault();
        loadWelcomePage();

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

    $(document).on("click", "#mybookmarks", (e) => {
        e.preventDefault();
        loadMyBookMarksPage();

    });

    $(document).on("click", "#profile", (e) => {
        e.preventDefault();
        loadProfilePage();

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

    function showSnackBar(msg = "") {
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");

        // Add the "show" class to DIV
        x.innerHTML = msg;
        x.className = "show";

        // After 3 seconds, remove the show class from DIV
        setTimeout(function () { x.className = x.className.replace("show", ""); }, 2000);
    }

    function domain_from_url(url) {
        var result
        var match
        if (match = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n\?\=]+)/im)) {
            result = match[1]
            if (match = result.match(/^[^\.]+\.(.+\..+)$/)) {
                result = match[1]
            }
        }
        return result
    }

    function displayPopularBookMarks() {
        $.ajax({
            url: "api/bookmarks/popular.php",
            type: 'GET',
            success: (res) => {
                // console.log(res);
                let content = '';
                res.data && res.data.forEach((i) => {
                    content += `
                    <tr>
                        <td><a rel="noopener noreferrer" target="_blank" href="${i.url}">${domain_from_url(i.url)}</a></td>
                        <td>${i.url}</td>
                        <td>${i.used_count}</td>
                    </tr>
                    `
                });
                $("#popularData").html(content);

            }
        });

    }

    function getMyBookMarks() {
        $.ajax({
            url: "api/bookmarks/userbookmark.php",
            type: 'GET',
            success: (res) => {
                console.log(res);
                let content = '';
                
                res.data && res.data.forEach((i, index) => {
                    content += `
                    <tr>
                        <td><a rel="noopener noreferrer" target="_blank" href="${i.bookmark_url}">${(i.title)}</a></td>
                        <td id="url-${index}">${i.bookmark_url}</td>
                        <td> 
                            <span id="edit-${index}" class="material-symbols-outlined action-btn">
                                edit
                            </span> 
                            <span id="delete-${index}" class="material-symbols-outlined action-btn">
                                delete
                            </span> 
                        </td>
                    </tr>
                    `
                });
                $("#mybookmarkData").html(content);

                res.data && res.data.forEach((i, index) => {

                    $(document).on("click", `#edit-${index}`, () => {


                        const editModal = $("#editModal");
                        const deleteItem = $("#deleteItem");
                        const url = $("#url-" + index).html();

                        deleteItem.html(url);
                        $("#editFormURL").val(url);
                        $("#editFormTitle").val(i.title);
                        $("#oldTitle").val(i.title);
                        $("#oldURL").val(url);
                        editModal.show();


                        $(document).on("submit", `#editForm`, (e) => {
                            e.preventDefault();
                            if (!validateURL($("#editFormURL").val())) {
                                showSnackBar("URL format not correct");
                                return;
                            }
                            const editForm = $(`#editForm`);
                            $.ajax({
                                type: editForm.attr('method'),
                                url: editForm.attr('action'),
                                data: editForm.serialize(),
                                success: (res) => {
                                    // console.log(res.message);
                                    editModal.hide();
                                    showSnackBar(res.message);
                                    loadMyBookMarksPage();
                                }
                            });
                        });

                        const closeModal = $(".modal-close");
                        closeModal.on("click", () => {
                            editModal.hide();

                        });

                    });

                    $(document).on("click", `#delete-${index}`, () => {

                        const deleteModal = $("#deleteModal");
                        const deleteItem = $("#deleteItem");
                        const url = $("#url-" + index).html();
                        deleteItem.html(url);
                        $("#formURL").val(url);
                        deleteModal.show();

                        $(document).on("submit", `#deleteBookMarkForm`, (e) => {
                            e.preventDefault();
                            const deleteForm = $(`#deleteBookMarkForm`);
                            $.ajax({
                                type: deleteForm.attr('method'),
                                url: deleteForm.attr('action'),
                                data: deleteForm.serialize(),
                                success: (res) => {
                                    // console.log(res.message);
                                    deleteModal.hide();
                                    showSnackBar(res.message);
                                    loadMyBookMarksPage();
                                }
                            });
                        });

                        const closeModal = $(".modal-close");
                        closeModal.on("click", () => {
                            deleteModal.hide();

                        });



                    });

                });

            }
        });


    }

    function addBookMark(form) {
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: (res) => {
                
                // console.log(res.message);
                showSnackBar(res.message);
                getMyBookMarks();
            }
        });

    }

    function validateURL(url) {
        console.log(url);
        const regex = new RegExp(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/gi);
        return url.match(regex);

    }

    function loadWelcomePage() {
        container.load("./components/welcome.php", () => {
            localStorage.setItem('page', 'welcome');
            displayPopularBookMarks();
        });
    }

    function loadProfilePage() {
        container.load("./components/profile.php", () => {
            localStorage.setItem('page', 'profile');
        });
    }

    function loadMyBookMarksPage() {
        container.load("./components/mybookmarks.php", () => {
            localStorage.setItem('page', 'mybookmarks');
            getMyBookMarks();
            $("#addbookmark").on("submit", (e) => {
                e.preventDefault();
                if (!validateURL($("#urlInput").val())) {
                    showSnackBar("URL format not correct");
                    return;
                }
                addBookMark($("#addbookmark"));
            });

        });
    }


});
