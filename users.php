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
                                class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Users</a>

                            <a href="./transfer.php"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Transfer</a>

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
                    class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Users</a>

                <a href="./transfer.php"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Transfer</a>

                <a href="./transactions.php"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Transactions</a>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->


    <!-- Main content start -->
    <?php
        include 'config.php';
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
    ?>
    <div class="flex-auto font-bold">
        <h1 class="text-4xl text-center my-2 underline" style="color: navy;">Users</h1>
        <table class="border-collapse border-2 border-green-800 table-auto w-10/12 mx-auto text-center">
            <thead class="text-2xl bg-yellow-200" style="color: darkblue;">
                <tr>
                    <th class="w-1/9 border-2 border-green-800 ">Customer ID</th>
                    <th class="w-1/3 border-2 border-green-800 ">Customer Name</th>
                    <th class="w-1/3 border-2 border-green-800 ">Customer Email</th>
                    <th class="w-2/9 border-2 border-green-800 ">Account Balance</th>
                </tr>
            </thead>
            <tbody class="text-xl bg-red-100" style="color: blue;">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                      echo '
                      <tr>
                          <td class="border-2 border-green-800">'.$row["id"].'</td>
                          <td class="border-2 border-green-800">'.$row["name"].'</td>
                          <td class="border-2 border-green-800">'.$row["email"].'</td>
                          <td class="border-2 border-green-800">&#8377; '.$row["currentBalance"].'.00</td>
                      </tr>
                      ';
                    }
                  } else {
                    echo "<tr><td colspan='4'>No User found.</td></tr>";
                  }
                ?>
            </tbody>
        </table>
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