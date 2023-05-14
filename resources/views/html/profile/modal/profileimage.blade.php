<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/chimg" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Image</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" accept="image/jpeg, image/png, image/webp" name="profilepic" value="profilepic" alt="Profile Image"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change Profile Image</button>
            </div>
        </form>
    </div>
</div>

<script>
    let show_password = [false, false]
    document.getElementById("toggle-show-password").addEventListener('click', () => {
        document.getElementById("password-input").type = show_password[0] ? "password" : "text"
        show_password[0] = !show_password[0]
    })
    document.getElementById("toggle-show-password-repeat").addEventListener('click', () => {
        document.getElementById("password-repeat-input").type = show_password[1] ? "password" : "text"
        show_password[1] = !show_password[1]
    })
</script>
