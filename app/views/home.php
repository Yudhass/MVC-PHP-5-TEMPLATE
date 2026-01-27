<!-- Home Page Content -->
<header class="bg-primary text-white text-center py-4 custom-header">
    <h1><?php echo esc($title); ?></h1>
</header>

<main class="mt-4">
    <h2 class="text-center">Home Page Data Test</h2>
    
    <!-- Button to trigger modal -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">
            Add Data
        </button>
    </div>

    <!-- Data Table -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_user)) : ?>
                    <?php foreach ($data_user as $row) : ?>
                        <tr>
                            <td><?php echo esc($row->id); ?></td>
                            <td><?php echo esc($row->nama); ?></td>
                            <td>
                                <!-- Button Edit -->
                                <button type="button" class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editDataModal_<?php echo esc($row->id); ?>"
                                    >
                                    Edit
                                </button>

                                <!-- Button Hapus -->
                                <form action="<?php echo esc(BASEURL); ?>delete/<?php echo esc($row->id); ?>" method="POST" style="display:inline-block;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo esc($row->id); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center">No data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Modal for adding data -->
<div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Add New Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding new data -->
                <form action="<?php echo esc(BASEURL); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required minlength="3" maxlength="100">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals for each data -->
<?php if (!empty($data_user)) : ?>
    <?php foreach ($data_user as $row) : ?>
        <div class="modal fade" id="editDataModal_<?php echo esc($row->id); ?>" tabindex="-1" aria-labelledby="editDataModalLabel_<?php echo esc($row->id); ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel_<?php echo esc($row->id); ?>">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing data -->
                        <form action="<?php echo esc(BASEURL); ?>update/<?php echo esc($row->id); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo esc($row->id); ?>">
                            <div class="mb-3">
                                <label for="nama_<?php echo esc($row->id); ?>" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama_<?php echo esc($row->id); ?>" name="nama" value="<?php echo esc($row->nama); ?>" required minlength="3" maxlength="100">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

        </div>
    </div>

    <?php if (!empty($data_user)) : ?>
        <?php foreach ($data_user as $row) : ?>
            <!-- Modal for Editing Data -->
            <div class="modal fade" id="editDataModal_<?php echo esc($row->id); ?>" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for editing data -->
                            <form action="<?php echo esc(BASEURL); ?>update/<?php echo esc($row->id); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="edit-nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="edit-nama" name="nama" value="<?php echo esc($row->nama); ?>" required minlength="3" maxlength="100">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editDataModal = document.getElementById('editDataModal');
            editDataModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');

                // Set value in form fields
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nama').value = nama;
            });
        });
    </script> -->
</body>

</html>