<?php

//include the backend file for total cards
include_once __DIR__ . '/../backend-config-file/index.inc.php';

//include the backend cards for showing the newest chruch registered
include_once __DIR__ . '/../backend-config-file/user.inc.php';

?>

<main class="px-5 mt-5 w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 mt-5">
  <!-- Card 1 -->
  <div class="flex items-center border border-[#ADACAC] rounded p-4 lg:p-2 w-full gap-3 flex-wrap">
        <img src="https://img.icons8.com/ios-glyphs/30/1E9E9E/money-bag.png" alt="Total Sales" width="24" height="24" class="mr-2" />
        <p class="min-w-0">
          Total Sales
          <span class="text-[#1E9E9E] font-semibold">
            <?php echo isset($_SESSION['totalsales']) ? htmlspecialchars($_SESSION['totalsales']) : '0.00'; ?>
        </span>
        </p>
      </div>

  <!-- Card 2 -->
  <div class="flex items-center border border-[#ADACAC] rounded p-4 lg:p-2 w-full gap-3 flex-wrap">
    <img src="https://img.icons8.com/ios-glyphs/30/1E9E9E/group.png" alt="Total Users" width="24" height="24" class="mr-2" />
    <p class="min-w-0">
      Total Demo
      <span class="text-[#1E9E9E] font-semibold">

        <?php

        //checking for the session created
        if (isset($_SESSION['totaldemos'])) {
          echo $_SESSION['totaldemos'];
        }else{
          echo 0;
        }

      ?>
    </span>
    </p>
    </div>

  <!-- Card 3 -->
  <div class="flex items-center border border-[#ADACAC] rounded p-4 lg:p-2 w-full gap-3 flex-wrap">
        <img src="https://img.icons8.com/material-sharp/24/1E9E9E/user.png" alt="Subscribers" width="24" height="24" class="mr-2" />
        <p class="min-w-0">
          Subscribers
          <span class="text-[#1E9E9E] font-semibold">100</span>
        </p>
      </div>

  <!-- Card 4 -->
  <div class="flex items-center border border-[#ADACAC] rounded p-4 lg:p-2 w-full gap-3 flex-wrap">
    <img src="https://img.icons8.com/forma-bold-filled/24/1E9E9E/imac-settings.png" alt="Total Systems" width="24" height="24" class="mr-2" />
    <p class="min-w-0">
      Total Churches
      <span class="text-[#1E9E9E] font-semibold">

        <?php

          if(isset($_SESSION['totalchurches'])){

            echo $_SESSION['totalchurches'];

          }else{
            echo 0;
          }

        ?>
    </span>
    </p>
    </div>

  <!-- Card 5 -->
  <div class="flex items-center border border-[#ADACAC] rounded p-4 lg:p-2 w-full gap-3">
        <img src="https://img.icons8.com/material-sharp/24/1E9E9E/user.png" alt="New Members" width="24" height="24" class="mr-2 w-6 h-6" />
        <div class="min-w-0 flex items-center justify-between w-full">
      <span class="truncate">This Month's Churches</span>
      <span class="text-[#1E9E9E] font-semibold ml-3">
      <?php
        if (isset($_SESSION['totalchurches'])) {
          echo htmlspecialchars($_SESSION['totalchurches']);
        } else {
          echo 0;
        }
      ?>
      </span>
        </div>
      </div>
    </div>

    <!-- Main content of the page -->
    <section class="mt-10 border border-[#ADACAC] rounded-xl py-4 flex flex-col lg:grid lg:grid-cols-2 lg:gap-4 ">
      <!-- Graph section -->
      <div>
  <div class="mb-5 mx-3 md:mx-5 flex justify-center">
          <!--includ the charting library-->

          <?php 
              // include the charting library. The existing file is models/Piecharts.php
              include_once __DIR__ . '/../models/Piecharts.php'; 
          ?>

        </div>
  <div class="mb-5 mx-3 md:mx-5 flex justify-center">

          <!--includ the charting library-->

             <?php 
              // include the charting library. The existing file is models/charts.php
              include_once __DIR__ . '/../models/Barcharts.php'; 
            ?>


        </div>
      </div>
      <!-- Users tables section -->
    <div class="flex flex-col gap-4 pl-3 md:pl-5 lg:pl-6">
  <div class="border border-[#ADACAC] p-3 rounded-xl w-full max-w-md mb-4 mx-auto">
          <h2 class="border-b border-b-[#ADACAC] p-3">New Registered Users</h2>

            <!-- displaying the users-->

            <?php
            $count = 0; 
            foreach($churches as $church): 
                if($count >= 2) break; // Limit to 5 entries
                $count++;
            ?>
            <p class="flex flex-col p-3 border-b border-b-[#ADACAC]">
                
                <?php echo htmlspecialchars($church['name']);?>

                <span class="flex text-xs">
                    <?php 
                    if(isset($church['contact_email'])) {
                    echo htmlspecialchars($church['contact_email']); }else{
                        echo "Email@gmail.com";
                    }
                    ?>
                </span>

            </p>
        <?php endforeach; ?>
          <a href="user.php" class="flex justify-center hover:underline mt-3">See All</a>
        </div>
      <div class="border border-[#ADACAC] p-3 rounded-xl w-full max-w-md mx-auto">
          <h2 class="border-b border-b-[#ADACAC] p-3">New Subscribers</h2>

            <?php
            // Prefer $latestPayers from backend include; fall back to empty array
            $latest = $GLOBALS['latestPayers'] ?? [];
            if (empty($latest)) {
                // show placeholder
                ?>
                <p class="flex flex-col p-3 border-b border-b-[#ADACAC]">
                  No recent payers found.
                  <span class="flex text-xs">&nbsp;</span>
                </p>
                <?php
            } else {
                foreach ($latest as $payer) {
                    ?>
                    <p class="flex flex-col p-3 border-b border-b-[#ADACAC]">
                        <?php echo htmlspecialchars($payer['name'] ?? 'Unnamed Church'); ?>
                        <span class="flex text-xs"><?php echo htmlspecialchars($payer['contact_email'] ?? ''); ?></span>
                    </p>
                    <?php
                }
            }
            ?>

          <a href="user.php" class="flex justify-center hover:underline mt-3">See All</a>
        </div>
      </div>
    </section>
  </main>
