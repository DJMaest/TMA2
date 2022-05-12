<div id="deleteModal" class="modal">

    <div style="height:200px;" class="modal-content center">
        <h3 class="modal-close">&#10005;</h3>
        <h3>Are you sure you want to delete <span id="deleteItem"></span>?</h3>
        <br>

        <form id="deleteBookMarkForm" method="POST" action="api/bookmarks/removebookmark.php">
            <input id="formURL" value="" name="url" type="text" hidden>

            <input style="margin-top:20px;" type="submit" value="DELETE" class="btn">

        </form>
    </div>

</div>