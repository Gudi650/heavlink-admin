<?php
// Pie chart fragment: show demo request counts for the last 4 months as a pie chart

// Ensure we have a PDO connection (reuse the same resolution strategy as other model files)
$candidates = [
  __DIR__ . '/../includes/dbh.inc.php',
  __DIR__ . '/../../admin/includes/dbh.inc.php',
  __DIR__ . '/../../includes/dbh.inc.php',
];
if (!isset($pdo) || !($pdo instanceof PDO)) {
  foreach ($candidates as $f) {
    $real = realpath($f);
    if ($real && file_exists($real)) {
      require_once $real;
      break;
    }
  }
  if ((!isset($pdo) || !($pdo instanceof PDO)) && isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
    $pdo = $GLOBALS['pdo'];
  }
}

// Build last 4 months labels (oldest → newest)
$months = [];
for ($i = 3; $i >= 0; $i--) {
  $ts = strtotime("-{$i} months");
  $key = date('Y-m', $ts);
  $months[$key] = date('M', $ts);
}

$counts = [];
if (isset($pdo) && $pdo instanceof PDO) {
  $startDate = date('Y-m-01', strtotime('-3 months'));
  $sql = "SELECT DATE_FORMAT(CreatedAt, '%Y-%m') AS ym, COUNT(*) AS cnt FROM demo WHERE CreatedAt >= :start GROUP BY ym ORDER BY ym";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':start', $startDate);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $r) {
      $counts[$r['ym']] = (int)$r['cnt'];
    }
  } catch (Exception $e) {
    error_log('Piecharts.php DB error: ' . $e->getMessage());
    $counts = [];
  }
} else {
  error_log('Piecharts.php: PDO connection not available');
}

// Palette for pie slices (re-use the palette from Barcharts for consistency)
$palette = ['#1E9E9E', '#60A5FA', '#F59E0B', '#10B981', '#EF4444', '#8B5CF6'];

$rows = [];
$i = 0;
foreach ($months as $ym => $label) {
  $val = isset($counts[$ym]) ? (int)$counts[$ym] : 0;
  $color = $palette[$i % count($palette)];
  $rows[] = [$label, $val, $color];
  $i++;
}

// Build a dynamic title
$first = $rows[0][0] ?? '';
$last = $rows[count($rows)-1][0] ?? '';
$chartTitle = 'Demo Requests';
if ($first || $last) {
  $chartTitle .= ' (' . $first . ($first && $last && $first !== $last ? ' – ' . $last : '') . ')';
}
?>

<!-- Chart block: ensure caption and legend are below the chart and centered -->
<div class="flex flex-col items-center w-full">
  <div id="piechart_values" class="w-11/12 md:w-2/3 lg:w-1/2 max-w-2xl h-40 md:h-56 lg:h-64 bg-white/0 rounded-md"></div>
  <p class="text-center text-base md:text-lg font-semibold text-gray-700 mt-1"><?php echo htmlspecialchars($chartTitle); ?></p>

  <!-- Debug line showing month:count for quick verification -->
  <p class="text-center text-sm text-gray-600 mt-1">
    <?php echo implode(' • ', array_map(function($r){ return htmlspecialchars($r[0]) . ':' . intval($r[1]); }, $rows)); ?>
  </p>
</div>

<!-- Google Charts loader -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {packages:['corechart']});
  google.charts.setOnLoadCallback(drawPieChart);

  function drawPieChart() {
    var phpRows = <?php echo json_encode($rows, JSON_UNESCAPED_SLASHES); ?>;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Count');
    for (var i = 0; i < phpRows.length; i++) {
      var label = String(phpRows[i][0] || '');
      var val = Number(phpRows[i][1]) || 0;
      data.addRow([label, val]);
    }

    // Build slices mapping so each slice uses the server-provided color
    var slices = {};
    for (var s = 0; s < phpRows.length; s++) {
      slices[s] = { color: phpRows[s][2] || '#1E9E9E' };
    }

    var options = {
      title: '<?php echo addslashes($chartTitle); ?>',
      legend: { position: 'bottom', textStyle: { color: '#6B7280' } },
      pieHole: 0.35,
      pieSliceText: 'percentage',
      pieSliceTextStyle: { color: '#374151', fontSize: 12 },
      slices: slices,
      backgroundColor: 'transparent',
      chartArea: { left: 20, top: 10, width: '70%', height: '80%' }
    };

    var container = document.getElementById('piechart_values');
    var chart = new google.visualization.PieChart(container);
    chart.draw(data, options);
  }

  // Redraw on resize (debounced)
  (function(){
    var resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        if (typeof google !== 'undefined' && google.visualization && google.visualization.PieChart) {
          drawPieChart();
        }
      }, 150);
    });
  })();
</script>
