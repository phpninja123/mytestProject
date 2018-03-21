<?php
require_once "API.php";
$tpbObj = new \TPB\API();

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

$keyword = $_POST['keyword'];
$orderBy = empty($_POST['orderBy']) ? 'Name' : $_POST['orderBy'];
$page = empty($_POST['page']) ? 1 : $_POST['page'];

// echo "<pre>"; print_r($_POST); die();

$searchResults = $tpbObj->searchByTitle($keyword, $orderBy, $page);

// echo "<pre>"; print_r($searchResults); die();

if( count($searchResults) > 0 )
{
	$pageCount = empty($searchResults[0]->PageCount) ? 0 : $searchResults[0]->PageCount;	
}
else
{
	$pageCount = 0;
}

$time_end = microtime_float();
$time = $time_end - $time_start;

echo '<p class="search-result-status" style="padding-top: 10px;padding-left: 2px;">About '.(number_format($pageCount)).' results ('.(@number_format($time, 2)).' seconds)</p>';

echo '<div class="row"> 
		<div class="col-md-12" style="text-align: center;">
			Order by : <div class="btn-group" role="group" aria-label="Order by">';
			echo '<button type="button" class="btn btn-default '.(($orderBy=='Name') ? 'active' : '').'" data-value="Name">Name</button>';
			echo '<button type="button" class="btn btn-default '.(($orderBy=='Uploaded') ? 'active' : '').'" data-value="Uploaded">Uploaded</button>';
			echo '<button type="button" class="btn btn-default '.(($orderBy=='Size') ? 'active' : '').'" data-value="Size">Size</button>';
			echo '<button type="button" class="btn btn-default '.(($orderBy=='Seeders') ? 'active' : '').'" data-value="Seeders">Seeders</button>';
			// echo '<button type="button" class="btn btn-default '.(($orderBy=='Leaders') ? 'active' : '').'" data-value="Leaders">Leaders</button>';
			echo '</div>
		</div>
	</div>';

// echo "<pre>"; print_r($pageCount); die();


	echo '<div class="row"> 
		<div class="col-md-12" style="text-align: center;">
			<ul class="pagination styled-square"><li class="prev"><a href="#">« PREV</a></li>';

	// $pages = ceil( $pageCount / 29 );

	// echo "<pre>"; print_r($pages); die();

	// for ($i=1; $i <= $pages; $i++) 
	// { 

	// 	echo '<li class="'.( ($i == $page) ? 'active' : '').'"><a href="#">'.$i.'</a></li>';
	// }                

		if(count($searchResults) == 0)
		{
			$attr = 'data-value=0';
		}
		else
		{
			$attr = 'data-value=100';
		}

	    echo '<li class="next" '.$attr.'><a href="#">NEXT »</a></li>
				</ul>
				<p style="font-weight : bold">Page '.$page.'</p>
				<input type="hidden" id="hidPageCount" value="'.$page.'" />
			</div>
		</div>';




if( count($searchResults) > 0 )
{
	foreach ($searchResults as $result) 
	{
		echo '<div class="list-group-item">';
		echo '<h4 class="list-group-item-heading"><a href="'.$result->Magnet.'" style="    word-break: break-word;">'.$result->Title.'</a></h4>';
		// echo '<p class="list-group-item-text"></p>';	
		echo '<p class="list-group-item-text">
				<a href="'.$result->Magnet.'" class="search-result-link" style="font-weight: bold;color: green;">Download : <span class="glyphicon glyphicon-magnet"></span></a>&nbsp;&nbsp;</a>
				<span style="font-weight: bold">Size : </span>'.$result->Size.'&nbsp;&nbsp;
				<span style="font-weight: bold">Seeders : </span>'.$result->Seeders.'&nbsp;&nbsp;
				<span style="font-weight: bold">Leeders : </span>'.$result->Leechers.'&nbsp;&nbsp;
				<span style="font-weight: bold">Uploaded : </span>'.date("d M Y", strtotime($result->Uploaded)).'&nbsp;&nbsp;
			  </p>';	
		echo '</div>';
	}
}
else
{
	echo '<br><div class="row"><div role="alert" class="col-md-12 alert alert-danger" style="text-align:center">No Results Found</div></div>';
}
// echo "<pre>"; print_r($searchResults); die();
// if (isset($searchResults[0])) {
// 	$topResult = $searchResults[0];
// 	echo '<div class="list-group">';
	
// 	foreach ($topResult as $infoType => $infoValue) 
// 	{
// 		echo '<div class="list-group-item">';
// 		echo '<h4 class="list-group-item-heading">Nulla porttitor accumsan tincidunt.</a></h4>';
// 		// echo $infoType . ": " . $infoValue . " <br>";
// 	}
// }
// else {
// 	echo "No results.";
// }
?>