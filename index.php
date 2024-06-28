<?php
require_once realpath(__DIR__ . "/src/views/components/user-card.php");
require_once realpath(__DIR__ . "/src/controllers/UserController.php");

$ctrl = new UserController();
$users = $ctrl->readAll();
?>

<?php include realpath(__DIR__ . "/src/views/templates/header.php"); ?>

<div class="box1">
    <h3>ALL USERS</h3>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-update-modal" data-mode="create" class="btn btn-primary">NEW USER</button>
</div>
<hr>
<div class="row">
    <?php
    foreach ($users as $user) {
        generateUserCard($user->id, $user->name, $user->email, $user->phone, $user->photoName);
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // catch modal show event
            $("#create-update-modal").on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget); // button that triggered the modal
                var mode = button.data("mode");

                $("#photo").val("");

                if (mode === "create") {
                    $("#user-id").val("");
                    $("#photo-name").val("")
                    $("#name").val("");
                    $("#email").val("");
                    $("#phone").val("");
                } else if (mode === "update") {
                    var userId = button.data("user-id");
                    $.ajax({
                        url: "public/read-user.php",
                        method: "GET",
                        data: {
                            "user-id": userId
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#user-id").val(response.id);
                            $("#photo-name").val(response.photoName);
                            $("#name").val(response.name);
                            $("#email").val(response.email);
                            $("#phone").val(response.phone);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    })
                }
            });

            // catch delete button click
            $(".delete-user-btn").click(function() {
                var userId = $(this).data("user-id");
                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        url: "public/delete-user.php",
                        type: "GET",
                        data: {
                            "user-id": userId
                        },
                        success: function(response) {
                            $('[data-user-id="' + userId + '"]').closest(".col-md-6").remove();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // catch modal save button click event
            $("#save-changes-btn").click(function() {
                var form = $("#create-update-modal form")[0];
                var formData = new FormData(form);

                var fileData = $("#photo").prop("files")[0];
                formData.append("photo", fileData)

                var userId = $("#user-id").val();
                var url = formData.get("user-id") ? "public/update-user.php" : "public/create-user.php"

                $.ajax({
                    url: url,
                    method: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function() {
                        location.reload();
                        alert("Request successfully executed!")
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText)
                    }
                });
            });

        });
    </script>
    <!-- Create/Update User Modal -->
    <div class="modal fade" id="create-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">USER DETAILS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <input type="hidden" id="user-id" name="user-id" value="">
                        <input type="hidden" id="photo-name" name="photo-name" value="">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save-changes-btn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php include realpath(__DIR__ . "/src/views/templates/footer.php"); ?>