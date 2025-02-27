<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <div id="loading" class="text-center">Loading...</div>
        <div id="error" class="alert alert-danger" style="display: none;"></div>

        <table class="table" id="userTable" style="display: none;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-list">
            </tbody>
        </table>

        <div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="userDetailsContent">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            fetchUsers();
        });

        function fetchUsers() {
            $('#loading').show();
            $('#userTable').hide();
            $('#error').hide();

            fetch('http://127.0.0.1:8000/api/users/') // Replace with your Django API URL
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let tableBody = $('#user-list');
                    tableBody.empty(); // Clear previous data

                    data.forEach(user => {
                        let row = `<tr>
                            <td>${user.id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td><button class="btn btn-sm btn-primary view-details" data-id="${user.id}">View Details</button></td>
                        </tr>`;
                        tableBody.append(row);
                    });

                    $('#loading').hide();
                    $('#userTable').show();
                })
                .catch(error => {
                    $('#loading').hide();
                    $('#error').text('An error occurred: ' + error.message);
                    $('#error').show();
                });
        }

        $(document).on('click', '.view-details', function() {
            let userId = $(this).data('id');
            fetchUserDetails(userId);
        });

        function fetchUserDetails(userId) {
            fetch(`http://127.0.0.1:8000/api/users/${userId}/`) //django url would come here.
                .then(response => response.json())
                .then(user => {
                    $('#userDetailsContent').html(`
                        <p><strong>ID:</strong> ${user.id}</p>
                        <p><strong>Username:</strong> ${user.username}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>First Name:</strong> ${user.first_name}</p>
                        <p><strong>Last Name:</strong> ${user.last_name}</p>
                    `);
                    $('#userDetailsModal').modal('show');
                });
        }
    </script>
</body>
</html>