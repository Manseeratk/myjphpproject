<?php
include('php/auth.php');
include('php/connect.php');

if ($LoggedInUserRole != "superAdmin")
{
    header('location: /home.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $sql = "select * from users where email = '" . $email . "'";

    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $error = "Email already in use. Please try another email.";
    } else {
        $sql = "insert into users (name, email, phone, password, role_id) values ('" . $name . "', '" . $email . "', '" . $phone . "', '" . $password . "', 2)";//md5($password)
        $res = $conn->query($sql);
        if ($res) {
            header('location: /home.php');
        } else {
            $error = "Invalid Username or Password";
        }
    }
}

$title = "Add Admin";
include "header.php";
?>

<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Admin</h4>
                </div>
                <div class="card-body">
                    <form class="form form-horizontal" method="post"> 
                        <div class="row">
                            <div class="col-6 offset-sm-1">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="first-name">First Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="first-name" class="form-control" name="name" placeholder="First Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="email-id">Email</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" id="email-id" class="form-control" name="email" placeholder="Email" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="contact-info">Mobile</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="number" id="contact-info" class="form-control" name="phone" placeholder="Mobile" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" />
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>





<?php include "footer.php" ?>