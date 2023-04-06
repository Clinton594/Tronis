<?php

$year = date("Y");
$month = date("m");

require_once(__DIR__ . "../../../controllers/Controllers.php");
$generic       = new Generic();
$paramControl = new ParamControl($generic);
$get          = (object)$_GET;
$uri          = $generic->getURIdata();
$uri->root    = absolute_filepath("{$uri->site}{$uri->backend}");
$db = $generic->connect();
$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);
$appCurrency = "$";
$pageId        = strToFilename($get->pageType);

$params        = $paramControl->get_params();

$months        = $paramControl->load_sources("months");

$coins = $generic->getFromTable("coin", "", 1, 0, ID_DESC);
$coins = array_remap($coins, array_column($coins, "symbol"));

$users = $generic->getFromTable("users", "", 1, 0, ID_DESC);
$users = array_remap($users, array_column($users, "id"));

$transactions = $generic->getFromTable("transaction", "status=1", 1, 0, ID_DESC);
$catgorized  = array_group($transactions, "tx_type");

$catgorized = array_map(function ($category) {
	$key = array_unique(array_column($category, 'tx_type'))[0];
	if ($key !== "EXC") {
		return array_filter($category, function ($row) {
			return $row->address !== "INTERNAL_WALLET";
		});
	} else return $category;
}, $catgorized);

$approval = $paramControl->load_sources("confirm");

$_color   = array("green", "red", "blue", "cyan darken-3", "teal darken-4", "orange", "light-green darken-3", "lime darken-1", "pink darken-4", "purple darken-4", "purple accent-4");
shuffle($_color);

$bb = [
	'MNT' => ['red', 'This Month', 'assistant'],
	'IN' => ['green', 'Total Deposits', 'all_inclusive'],
	'OUT' => ['orange', 'Withdrawals', 'beenhere'],
	'EXC' => ['blue', 'EXCHANGED', 'business_center'],
];

foreach ($bb as $key => $value) {
	$temp = $catgorized[strtolower($key)] ?? [];
	if ($key == "MNT") {
		$temp = $catgorized["in"] ?? [];
		$temp = array_filter($temp, function ($row) use ($month, $year) {
			$date = new DateTime($row->date_created);
			return ($date->format("m") == $month && $date->format("Y") == $year);
		});
	}
	$bb[$key][] = myround(sumPrices($temp, $coins));
}

$thisYear = array_filter($catgorized["in"] ?? [], function ($row) use ($year) {
	$date = new DateTime($row->date_created);
	return ($date->format("Y") == $year);
});

// Monthly Data
$monthly = array_map(
	function ($row) use ($coins) {
		return sumPrices($row, $coins);
	},
	array_group(
		array_map( //Returns the month in digits
			function ($row) {
				$date = new DateTime($row->date_created);
				$row->month = $date->format("n");
				return $row;
			},
			$thisYear
		),
		"month"
	)
);
ksort($monthly);

// Coin Performance
$performance = array_map(
	function ($row) use ($coins) {
		return sumPrices($row, $coins);
	},
	array_group(
		$thisYear,
		"coin"
	)
);


$graph = [
	"report__chart" => [
		"labels" => array_extract($months, array_keys($monthly)),
		"datasets" => [
			[
				"label" => "",
				"backgroundColor" => array_range($_color, count($monthly)),
				"data" => array_values($monthly),
			]
		]
	],
	"coin_performance" => [
		"labels" => array_map("strtoupper", array_keys($performance)),
		"datasets" => [
			[
				"label" => "",
				"backgroundColor" => array_range($_color, count($performance)),
				"data" => array_values($performance),
			]
		]
	]
];

?>
<div class="content" id="dashboard-new">
	<div class="hide" id="flash_dashboard-new"><?= json_encode($graph) ?></div>
	<div class="container-fluid">
		<!-- Widgets -->
		<div class="row">
			<?php foreach ($bb as $key => $item) { ?>
				<div class="col-6 col-lg-3">
					<div class="counter-box text-center white">
						<div class="text font-17 m-b-5"><?= $item[1] ?></div>
						<h3 class="m-b-10 m-t-0" style="font-size: 1rem;"><?= $item[3] ?>
							<i class="material-icons tiny col-<?= $item[0] ?>">trending_up</i>
						</h3>
						<div class="icon">
							<i class="material-icons col-<?= $item[0] ?>" style="font-size: xx-large;"> <?= $item[2] ?></i>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<!-- #END# Widgets -->
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="header">
						<h2>Monthly Deposit Transactions</h2>
					</div>
					<div class="body">
						<div class="recent-report__chart">
							<canvas height="150px" id="report__chart" data-type="line"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="card">
					<div class="header">
						<h2>Yearly Coin Performance</h2>
					</div>
					<div class="body">
						<div class="recent-report__chart">
							<canvas height="150px" id="coin_performance" data-type="bar"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<!-- Task Info -->
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<div class="card">
					<div class="header">
						<h2>Latest Deposit Transactions</h2>
					</div>
					<div class="tableBody">
						<div class="table-responsive">
							<table class="table table-hover dashboard-task-infos">
								<thead>
									<tr>
										<th>Coin</th>
										<th>User</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach (array_range($catgorized["in"] ?? [], 15) as $row) { ?>
										<tr>
											<td class="table-img">
												<img src="<?= $coins[$row->coin]->logo ?>" alt="" width="35px">
											</td>
											<td><?= $users[$row->user_id]->first_name ?></td>
											<td><?= round($row->amount, $coins[$row->coin]->decimals) ?></td>
											<td>
												<span class="px-2 col-<?= ["yellow", "green", "orange"][$row->status] ?>"><?= $approval[$row->status] ?></span>
											</td>
											<td><?= date("d, M Y", strtotime($row->date_created)) ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Task Info -->
			<!-- Browser Usage -->
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="card">
					<div class="header">
						<h2>New Members</h2>
					</div>
					<div class="body">
						<div id="new-orders" class="media-list position-relative">
							<div class="table-responsive">
								<table id="new-orders-table" class="table table-hover table-xl mb-0">
									<thead>
										<tr>
											<th class="">Frist Name</th>
											<th class="border-top-0">Last Name</th>
											<th class="border-top-0">Date</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach (array_range($users, 10) as $key => $user) { ?>
											<tr>
												<td class="text-truncate"><?= $user->first_name ?></td>
												<td class="text-truncate"><?= $user->last_name ?></td>
												<td class="text-truncate"><?= date("d, M Y", strtotime($user->date)) ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Browser Usage -->
		</div>
	</div>
</div>
<script src="<?= $uri->backend ?>js/chart.min.js"></script>
<script src="<?= $uri->backend ?>backendProject/js/apexcharts.min.js"></script>
<script language="javascript" type="text/javascript">
	let flash = $("#flash_dashboard-new").text();
	flash = isJson(flash);
	$("#flash_dashboard-new").remove();
	if (flash) {
		for (var canvas in flash) {
			if (flash.hasOwnProperty(canvas)) {
				let thiscanvas = $("#dashboard-new").find("#" + canvas);
				let type = thiscanvas.data("type");
				let data = flash[canvas];
				// console.log(data);
				thiscanvas.plotGraph(type, data);
				thiscanvas.css({
					height: thiscanvas.data("height")
				})
			}
		}
	}
</script>