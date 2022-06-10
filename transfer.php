<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./public/images/bg.jpg">
    <title>Basic Banking System</title>

    <!-- Custom CSS start-->
    <link href='./public/css/common.css' rel='stylesheet'>
    <!-- Custom CSS end -->

    <!-- 3rd party CSS & Scripts start -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- 3rd party CSS & Scripts end -->
</head>

<body class="flex flex-col h-screen">
    <div class="background"></div>


    <!-- Navbar start -->
    <nav class="bg-gray-800 flex-initial">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Button with hamburger menu icon -->
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        id="mobile-menu-toggle">
                        <!-- Icon when Menu is closed -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when Menu is open -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-between">
                    <div class="flex-shrink-0 flex items-center text-white text-3xl">
                        Basic Banking System
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="./index.html"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>

                            <a href="./users.php"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Users</a>

                            <a href="./transfer.php"
                                class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Transfer</a>

                            <a href="./transactions.php"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="./index.html"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                    aria-current="page">Home</a>

                <a href="./users.php"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Users</a>

                <a href="./transfer.php"
                    class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Transfer</a>

                <a href="./transactions.php"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Transactions</a>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->


    <!-- PHP Scripts starts-->
    <?php
        include 'config.php';
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        $customers = array();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($customers, $row);
            }
        }
    ?>

    <?php
        $transfer_fromErr = $transfer_toErr = $amountErr = "";
        $transfer_from = $transfer_to = "";
        $amount = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $flag = true;

            if (empty($_POST["transfer_from"])) {
                $flag = false;
                $transfer_fromErr = "Transfer From can't be empty";
            } else {
                $transfer_from = test_input($_POST["transfer_from"]);
            }
                
            if(empty($_POST["transfer_to"])) {
                $transfer_toErr = "Transfer To can't be empty";
                $flag = false;
            } else {
                $transfer_to = test_input($_POST["transfer_to"]);
            }

            if (empty($_POST["amount"])) {
                $amountErr = "Amount can't be empty";
                $flag = false;
            } else {
                $amount = test_input($_POST["amount"]);
            }

            if($amount <= 0) {
                $amountErr = "Amount can't be zero or negative";
                $flag = false;
            }

            if($transfer_from == $transfer_to) {
                $transfer_toErr = "Transfer To can't be same as transfer from person";
                $flag = false;
            }

            $transfer_from_data = "";
            $transfer_to_data = "";
            for($x = 0; $x < count($customers); $x++) {
                if($customers[$x]['id'] == $transfer_from) {
                    $transfer_from_data = $customers[$x];
                }
                if($customers[$x]['id'] == $transfer_to) {
                    $transfer_to_data = $customers[$x];
                }
            }

            if($amount > $transfer_from_data['currentBalance']) {
                $amountErr = "Amount can't be greater than balance";
                $flag = false;
            }

            if($flag == true) {
                $sql2 = "UPDATE customers SET currentBalance = currentBalance - $amount WHERE id = $transfer_from"; 
                $sql3 = "UPDATE customers SET currentBalance = currentBalance + $amount WHERE id = $transfer_to";
                $sql4 = 'INSERT INTO transfer (transfer_from, transfer_to, amount) VALUES ("' . $transfer_from_data["name"] . '", "' . $transfer_to_data["name"] . '",' . $amount . ')';
                $result2 = $conn->query($sql2);
                $result3 = $conn->query($sql3);
                $result4 = $conn->query($sql4);
                if($result4 != true) {
                    $amountErr = $sql4 . "<br>" . $conn->error;
                }
                echo "<script type='text/javascript'>window.location.href = '/users.php';</script>";
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <!-- PHP Script ends -->

    <!-- Main content start -->
    <div class="flex-auto flex flex-col md:flex-row lg:flex-row flex-wrap justify-around content-evenly">
        <form method="POST" class="bg-indigo-300 mb-6 p-4 w-10/12 md:w-8/12 lg:w-4/12"
            action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <h3 class="text-3xl font-medium leading-6 text-gray-900 text-center mb-8">Transfer Money</h3>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-bold text-lg text-grey-darkest" for="first_name">Transfer From</label>
                <select class='border py-2 px-3 text-grey-darkest' required name='transfer_from'>
                    <?php
                        foreach($customers as $row) {
                            if (isset($transfer_from) && $transfer_from==$row["id"]) {
                                echo "<option selected value='".$row["id"]."'>". $row["name"]. " (Balance = ". $row['currentBalance']. ")</option>";
                            } else {
                                echo "<option value='".$row["id"]."'>". $row["name"]. " (Balance = ". $row['currentBalance']. ")</option>";
                            }            
                        }
                    ?>
                </select>
                <span>
                    <?php echo $transfer_fromErr;?>
                </span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-bold text-lg text-grey-darkest" for="first_name">Transfer To</label>
                <select class='border py-2 px-3 text-grey-darkest' required name='transfer_to'>
                    <?php
                        foreach($customers as $row) {
                            if (isset($transfer_to) && $transfer_to==$row["id"]) {
                                echo "<option selected value='".$row["id"]."'>". $row["name"]. " (Balance = ". $row['currentBalance']. ")</option>";
                            } else {
                                echo "<option value='".$row["id"]."'>". $row["name"]. " (Balance = ". $row['currentBalance']. ")</option>";
                            }                        
            
                        }
                    ?>
                </select>
                <span>
                    <?php echo $transfer_toErr;?>
                </span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-bold text-lg text-grey-darkest" for="first_name">Amount</label>
                <input type='number' class="border py-2 px-3 text-grey-darkest" min='1' required
                    value="<?php echo $amount;?>" name='amount'>
                <span>
                    <?php echo $amountErr;?>
                </span>
            </div>
            <button class="block text-white uppercase text-lg mx-auto p-4 rounded" type="submit"
                style="background-color: teal;">Transfer</button>
        </form>
    </div>
    <!-- Main content end -->


    <!-- Footer Start -->
    <footer class="text-center text-2xl p-2 text-green-900 bg-yellow-300 flex-initial" id="footer">
    </footer>
    <!-- Footer end -->


    <!-- Custom script start -->
    <script src='./public/js/navbar.js'></script>
    <!-- Custom script end -->

</body>

</html>