<?php
function generateUserCard($id, $name, $email, $phone, $photoName) {
    $photoPath = "uploads/$id/$photoName";
    echo '
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="card h-100">
            <div class="row g-0 h-100">
                <div class="col-md-4">
                    <img src="' . $photoPath . '" class="img-fluid rounded-start h-100" alt="Profile Picture">
                </div>
                <div class="col-md-8 d-flex flex-column">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">' . $name . '</h5>
                        <p class="card-text"><strong>Email:</strong> ' . $email . '</p>
                        <p class="card-text"><strong>Phone:</strong> ' . $phone . '</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-warning me-2" data-toggle="modal" data-target="#create-update-modal" data-mode="update" data-user-id="' . $id . '">U</button>
                        <button type="button" class="btn btn-sm btn-danger delete-user-btn" data-user-id="' . $id . '">D</button>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}
?>
