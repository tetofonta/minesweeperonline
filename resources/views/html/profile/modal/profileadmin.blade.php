<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/chpsw" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group my-3">
                    <input type="password" name="password" placeholder="Password" id="password-input" aria-label="Password" class="form-control form-control-lg"/>
                    <button type="button" class="btn btn-primary" id="toggle-show-password">
                        <i class="fas fa-eye" id="show-password-button"></i>
                    </button>
                </div>
                <div class="input-group my-3">
                    <input type="password" name="password-repeat" placeholder="Repeat Password" id="password-repeat-input" aria-label="Password Repeat" class="form-control form-control-lg"/>
                    <button type="button" class="btn btn-primary" id="toggle-show-password-repeat">
                        <i class="fas fa-eye" id="show-password-repeat-button"></i>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change Password</button>
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
