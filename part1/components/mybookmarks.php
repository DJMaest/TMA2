<div class="form-container">
    <form id="addbookmark" method="POST" action="api/bookmarks/addbookmark.php">

        <span class="material-symbols-outlined">
            bookmark
        </span>
        <p>Bookmarks</p>
        <div class="input-field">
            <label for="username">URL</label>
            <input id="urlInput" style="width:300px" name="url" type="text"><br>
            <p class="warning" id="urlWarn">The URL is invalid.</p>
        </div>
        <br>

        <div class="input-field">
            <label for="pass">Link Name</label>
            <input style="width:300px" name="title" type="text">
        </div>
        <br>
        <input style="width:100px" type="submit" name="add" value="ADD" class="btn">

    </form>

</div>
<h3>My BookMarks</h3>
<table class="centered">
    <thead>
        <tr>
            <th>Link</th>
            <th>URL</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="mybookmarkData">

    </tbody>
</table>
<?php require_once('deleteModal.php') ?>
<?php require_once('editModal.php') ?>