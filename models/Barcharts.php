<?php // Chart fragment: responsive Google ColumnChart styled to match admin UI
// Backend: prepare monthly church counts for the last 12 months
// Ensure we have a PDO connection available
// Ensure we have a PDO connection available. Try several likely locations and fall back to global.
$candidates = [
  __DIR__ . '/../includes/dbh.inc.php',            // admin/includes/dbh.inc.php
  __DIR__ . '/../../admin/includes/dbh.inc.php',    // when included from other folders
  __DIR__ . '/../../includes/dbh.inc.php',         // alternate relative path
];
// Only attempt to (re)load the DB connection if we don't already have one.
if (!isset($pdo) || !($pdo instanceof PDO)) {
    foreach ($candidates as $f) {
        $real = realpath($f);
        if ($real && file_exists($real)) {
            require_once $real;
            break;
        }
    }

    // If require_once didn't set $pdo, try to pick it up from $GLOBALS (some pages may set it there)
    if ((!isset($pdo) || !($pdo instanceof PDO)) && isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
        $pdo = $GLOBALS['pdo'];
    }

    // Final check — if PDO still not available, log and continue with zeros fallback
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        error_log('Barcharts.php: PDO connection not available');
    }
}

// Build a list of YYYY-MM keys for the last 4 months (oldest to newest)
$months = [];
for ($i = 3; $i >= 0; $i--) {
  $ts = strtotime("-{$i} months");
  $key = date('Y-m', $ts);
  $months[$key] = date('M', $ts); // label
}

$rows = [];
$counts = [];
if (isset($pdo) && $pdo instanceof PDO) {
  // Determine the first day of the oldest month we want to include so we count full months
  // e.g. if showing last 4 months (including current), start from YYYY-MM-01 three months ago
  $startDate = date('Y-m-01', strtotime('-3 months'));

  // Query counts grouped by year-month for the last 4 months (use a bound parameter)
  $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS cnt FROM churches WHERE created_at >= :start GROUP BY ym ORDER BY ym";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':start', $startDate);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $r) {
      $counts[$r['ym']] = (int)$r['cnt'];
    }
  } catch (Exception $e) {
    // Log the exception to the PHP error log — helpful when debugging locally
    error_log('Barcharts.php DB error: ' . $e->getMessage());
    // fall back to zeros
    $counts = [];
  }
} else {
  error_log('Barcharts.php: PDO connection not available');
}

// Prepare rows in chronological order with a chosen color palette (always produce 12 rows)
$palette = ['#1E9E9E', '#60A5FA', '#F59E0B', '#10B981', '#EF4444', '#8B5CF6', '#F97316', '#06B6D4', '#3B82F6', '#84CC16', '#E11D48', '#0EA5A4'];
$i = 0;
foreach ($months as $ym => $label) {
    $count = isset($counts[$ym]) ? (int)$counts[$ym] : 0;
    $color = $palette[$i % count($palette)];
    $rows[] = [$label, $count, $color];
    $i++;
}
// $rows is an array of [label, int value, color]
?>
<!-- Chart block: ensure caption is below the chart and centered -->
<div class="flex flex-col items-center w-full">
  <div id="columnchart_values" class="w-11/12 md:w-3/4 lg:w-2/3 max-w-3xl h-40 md:h-56 lg:h-64 bg-white/0 rounded-md"></div>
  <!-- Chart title / caption placed below the chart (bolder & slightly larger) -->

  <?php
    // Build a descriptive chart title based on the first and last month labels
    $firstLabel = isset($rows[0][0]) ? $rows[0][0] : '';
    $lastLabel = isset($rows[count($rows) - 1][0]) ? $rows[count($rows) - 1][0] : '';
    $chartTitle = 'New Churches Registered';
    if ($firstLabel || $lastLabel) {
      $chartTitle .= ' (' . $firstLabel . ($firstLabel && $lastLabel && $firstLabel !== $lastLabel ? ' – ' . $lastLabel : '') . ')';
    }
  ?>

  <p class="text-center text-base md:text-lg font-semibold text-gray-700 mt-1">
    <?php echo htmlspecialchars($chartTitle); ?>
  </p>

  <!-- Debug / confirmation line: shows server-side month counts so you can verify November value -->
  <p class="text-center text-sm text-gray-600 mt-1">
    <?php
      // build a small human-readable summary: e.g. "Aug:0 • Sep:4 • Oct:0 • Nov:3"
      $parts = array_map(function($r){ return htmlspecialchars($r[0]) . ':' . intval($r[1]); }, $rows);
      echo implode(' • ', $parts);
    ?>
  </p>

  <!-- Fallback simple HTML bars (in case Google Charts doesn't render correctly) -->
  <?php
    $values = array_map(function($r){ return intval($r[1]); }, $rows);
    $maxVal = $values ? max($values) : 0;
    if ($maxVal < 1) $maxVal = 1; // avoid division by zero
  ?>
  <div class="w-11/12 md:w-3/4 lg:w-2/3 max-w-3xl mt-3">
    <div class="grid grid-cols-<?php echo count($rows); ?> gap-4 items-end" style="grid-auto-rows:1fr">
      <?php foreach($rows as $r):
        $label = htmlspecialchars($r[0]);
        $val = intval($r[1]);
        $pct = round(($val / $maxVal) * 100);
        $color = htmlspecialchars($r[2] ?? '#1E9E9E');
      ?>
      <div class="flex flex-col items-center text-sm">
        <div class="h-24 w-6 rounded-t" style="background: <?php echo $color; ?>; height: <?php echo max(6, $pct); ?>%; min-height: 6px; width: 28px; display:block;"></div>
        <div class="mt-2 text-xs"><?php echo $label; ?></div>
        <div class="text-xs text-gray-700"><?php echo $val; ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<!-- Google Charts loader -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    // Data rows prepared by PHP (label, value, color)
    var phpRows = <?php echo json_encode($rows, JSON_UNESCAPED_SLASHES); ?>;
    // Build DataTable with explicit column types to avoid type inference issues
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Label');
    data.addColumn('number', 'Value');
    data.addColumn({type: 'string', role: 'style'});

    for (var i = 0; i < phpRows.length; i++) {
      var label = phpRows[i][0];
      // coerce numeric values explicitly
      var val = Number(phpRows[i][1]);
      if (!isFinite(val)) val = 0;
      var color = phpRows[i][2] || '#1E9E9E';
      data.addRow([label, val, color]);
    }

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, { calc: 'stringify', sourceColumn: 1, type: 'string', role: 'annotation' }, 2]);

    var container = document.getElementById('columnchart_values');

    var options = {
      title: '<?php echo addslashes($chartTitle); ?>',
      legend: { position: 'none' },
  chartArea: { left: 40, top: 20, width: '80%', height: '60%' },
      // remove axis gridlines / background lines for a cleaner UI
      hAxis: {
        textStyle: { color: '#6B7280' },
        gridlines: { color: 'transparent' },
        minorGridlines: { color: 'transparent' }
      },
      vAxis: {
        textStyle: { color: '#6B7280' },
        minValue: 0,
        gridlines: { color: 'transparent' },
        minorGridlines: { color: 'transparent' }
      },
      backgroundColor: 'transparent',
  // make bars thinner for a lighter visual appearance
  bar: { groupWidth: '65%' },
      annotations: { alwaysOutside: false, textStyle: { fontSize: 11, color: '#374151' } }
    };

    // Debug: log server rows and data table to console
    try {
      console.log('phpRows', phpRows);
      if (data && data.toJSON) console.log('data JSON', data.toJSON());
      else console.log('data', data);
    } catch (e) { console.log('chart debug log error', e); }

    // compute max value to ensure vAxis scale is appropriate (so small values like 3 are visible)
    var maxVal = 0;
    for (var r = 0; r < data.getNumberOfRows(); r++) {
      var v = Number(data.getValue(r, 1));
      if (isFinite(v) && v > maxVal) maxVal = v;
    }
    if (maxVal <= 0) maxVal = 1;
    // set a comfortable max (20% headroom)
    options.vAxis = options.vAxis || {};
    options.vAxis.viewWindowMode = 'explicit';
    options.vAxis.viewWindow = { min: 0, max: Math.ceil(maxVal * 1.2) };

    // make annotations always outside so numbers are visible even for small bars
    options.annotations = options.annotations || {};
    options.annotations.alwaysOutside = true;
    options.annotations.textStyle = options.annotations.textStyle || {};
    options.annotations.textStyle.fontSize = 12;

    var chart = new google.visualization.ColumnChart(container);
    chart.draw(view, options);
  }

  // Redraw the chart on resize (debounced) so it fits responsive container
  (function(){
    var resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        if (typeof google !== 'undefined' && google.visualization && google.visualization.ColumnChart) {
          drawChart();
        }
      }, 150);
    });
  })();
</script>