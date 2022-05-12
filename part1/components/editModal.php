<div id="editModal" class="modal">

    <div class="modal-content center">
        <h3 class="modal-close">&#10005;</h3>
        <h3>Edit Bookmark</h3>
        <br>

        <form id="editForm" method="POST" action="api/bookmarks/editbookmark.php">

            <div class="input-field">
                <label for="username">URL</label>
                <input id="oldURL" name="url" type="text" hidden>
                <input id="editFormURL" name="new_url" type="text">

            </div>
            <br>

            <div class="input-field">
                <label for="pass">Title</label>
                <input id="oldTitle" name="title" type="text" hidden>
                <input id="editFormTitle" name="new_title" type="text">

            </div>
            <br>
            <input id="#update" type="submit" value="UPDATE" class="btn">

        </form>
    </div>

</div>