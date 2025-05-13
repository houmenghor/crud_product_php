<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php

try {
    $host = 'fdb1027.runhosting.com';
    $username = '4632482_product';
    $password = 'Menghor100@@';
    $database = '4632482_product';
    $connection = new mysqli($host, $username, $password, $database);
} catch (\Throwable $th) {
    //throw $th;
}
function insertData()
{
    global $connection;
    if (isset($_POST['btnSave'])) {
        $name = $_POST['name'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        $thumbnail = rand(1, 100000) . '-' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'image/' . $thumbnail);
        if (!empty($name) && !empty($qty) && !empty($price) && !empty($thumbnail)) {
            try {
                $sql = "INSERT INTO `tbl_product`(`name`, `qty`, `price`, `thumbnail`)
                    VALUES ('$name','$qty','$price','$thumbnail')";
                $row = $connection->query($sql);
            } catch (\Throwable $th) {
                //throw $th;
            }
            if ($row) {
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Product Added!",
                            text: "Product has been added successfully.",
                            icon: "success",
                            button: "Ok!",
                        });
                    })
                </script>
                ';
            }
        } else {
            echo 00;
        }
    }
}
insertData();

function readData()
{
    global $connection;
    try {
        $sql = "SELECT * FROM `tbl_product` WHERE status = 1 ORDER BY id ASC";
        $result = $connection->query($sql);
        $i = 1;
        while ($data = mysqli_fetch_assoc($result)) {
            echo '
            <tr>
                <td>' . $data['id'] . '</td>
                <td>' . $data['name'] . '</td>
                <td>' . $data['qty'] . '</td>
                <td>$' . $data['price'] . '</td>
                <td>
                    <img src="image/' . $data['thumbnail'] . '" width="100" alt="">
                </td>
                <td>
                    <button id="openUpdate" class="btn btn-warning mx-2" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Update</button>
                    <button type="button" 
                            class="btn btn-danger openDeleteBtn" 
                            data-id="' . $data['id'] . '" 
                            data-bs-toggle="modal" 
                            data-bs-target="#exampleModalDelete">
                        Delete
                    </button>

                </td>
            </tr>
            ';
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function deleteData()
{
    global $connection;
    if (isset($_POST['btnDelete'])) {
        $id = $_POST['tmp_id'];
        try {
            $sql = "UPDATE `tbl_product` SET `status` = 0 WHERE id = '$id'";
            $result = $connection->query($sql);
            if ($result) {
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Product Deleted!",
                            text: "Product has been deleted successfully.",
                            icon: "success",
                            button: "OK",
                        });
                    })
                </script>
                ';
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

deleteData();

function updateData()
{
    global $connection;
    if (isset($_POST['btnUpdate'])) {
        $id = $_POST['hide_id'];
        $name = $_POST['name'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        
        if (!empty($_FILES['thumbnail']['name'])) {
            $thumbnail = rand(1, 100000) . '-' . $_FILES['thumbnail']['name'];
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'image/' . $thumbnail);
        } else {
            $thumbnail = $_POST['hide_thumbnail'];
        }

        if (!empty($name) && !empty($qty) && !empty($price) && !empty($thumbnail)) {
            try {
                $sql = "UPDATE `tbl_product` SET `name`='$name',`qty`='$qty',`price`='$price',`thumbnail`='$thumbnail' WHERE `id`='$id'";
                $row = $connection->query($sql);
            } catch (\Throwable $th) {
                //throw $th;
            }
            if ($row) {
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Product Updated!",
                            text: "Product has been updated successfully.",
                            icon: "success",
                            button: "Ok",
                        });
                    })
                </script>
                ';
            }
        } else {
            echo 00;
        }
    }
}
updateData();
