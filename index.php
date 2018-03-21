<?php 
//print_r($_GET); die();
$keyword = empty($_REQUEST['keyword']) ? 'browse' : $_REQUEST['keyword'];
$orderBy = empty($_POST['orderBy']) ? 'Name' : $_POST['orderBy'];
$page = empty($_POST['page']) ? 1 : $_POST['page'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>AdFreeTorrent | Seach Torrents without worrying about popup ads</title>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="Search dozens of torrent without worry about popup ads. Enjoy downloading ad free torrents. Download music, movies, games, software and much more. The ad free torrent is the world's best BitTorrent site.">
	    <meta name="keywords" content="adfreetorrents.com, get rid of ads,movies torrent, torrent movie download , popup ads,stop ads, ad remover, stop google ads, ad free, no popups,mp3, avi, bittorrent, torrent, torrents, movies, music, games, applications, apps, download, upload, share, kopimi, magnets, magnet">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link lazyload="1" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link lazyload="1" rel="stylesheet" type="text/css" href="css/new_loader.css">
		<!-- Optional theme -->
		<link lazyload="1" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link lazyload="1" rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<!-- Include Twitter Bootstrap and jQuery: -->
		<!-- <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/> -->
		<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
		<!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
		 
		<!-- Include the plugin's CSS and JS: -->
		<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

		<style type="text/css">
		.jumbotron p{
			font-size: 15px !important;
		}

		a[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]
		{
			display: none;
		}

		.ui-autocomplete-loading { background:url('images/ui-anim_basic_16x16.gif') no-repeat right center }

		</style>
	</head>
	<body class="jumbotron" style="padding-top: 25px;padding-bottom: 25px;">
		
		<div class="panel-body" >
            <div>
            	<h2 align="center">Ad Free Torrents</h2>
                <div class="input-group">
                    <input id="keyword" value="<?php echo ($keyword != 'browse') ? $keyword : ''; ?>" name="keyword" type="text" class="form-control" placeholder="ad free torrents search">
                    <span class="input-group-btn">
                        <button id="search" class="btn btn-primary btn-flat" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>

            <div id="result_container">
			<?php
			require_once "API.php";
			$tpbObj = new \TPB\API();

			function microtime_float()
			{
			    list($usec, $sec) = explode(" ", microtime());
			    return ((float)$usec + (float)$sec);
			}

			$time_start = microtime_float();
			$searchResults = $tpbObj->searchByTitle($keyword, $orderBy, $page);

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
			if( $keyword != 'browse' )
				{
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

				
					echo '<div class="row"> 
						<div class="col-md-12" style="text-align: center;">
							<ul class="pagination styled-square"><li class="prev"><a href="#">« PREV</a></li>';

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
				}
				else
				{
					echo '<h4 align="center"> ---- Top 100 ----</h4>';
				}

			if( count($searchResults) > 0 )
			{
				foreach ($searchResults as $result) 
				{
					echo '<div class="list-group-item">';
					echo '<h4 class="list-group-item-heading"><a href="'.$result->Magnet.'" style="    word-break: break-word;">'.$result->Title.'</a></h4>';
					echo '<p class="list-group-item-text">
							<a href="'.$result->Magnet.'" class="search-result-link" style="font-weight: bold;color: green;">Download : <span class="glyphicon glyphicon-magnet"></span></a>&nbsp;&nbsp;</a>
							<span style="font-weight: bold">Size : </span>'.$result->Size.'&nbsp;&nbsp;
							<span style="font-weight: bold">Seeders : </span>'.$result->Seeders.'&nbsp;&nbsp;
							<span style="font-weight: bold">Leeders : </span>'.$result->Leechers.'&nbsp;&nbsp;
							<span style="font-weight: bold">Uploaded : </span>'.$result->Uploaded.'&nbsp;&nbsp;
						  </p>';	
					echo '</div>';
				}
			}
			else
			{
				echo '<br><div class="row"><div role="alert" class="col-md-12 alert alert-danger" style="text-align:center">No Results Found</div></div>';
			}
			?>
			</div>
            <br>
            <div class="row">
            	<div class="col-md-12" style="text-align:center">
            		<p>For any queries feel free to contact me at <a href="mailto:info@adfreetorrents.com">info@adfreetorrents.com</a></p>
            		<p>Before downloading torrents, please make sure that you have any <a target="_BLANK" href="https://www.google.co.in/url?sa=t&rct=j&q=&esrc=s&source=web&cd=5&cad=rja&uact=8&ved=0ahUKEwjV0Pnml9LUAhWMvo8KHVASAWwQFgiiATAE&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FComparison_of_BitTorrent_clients&usg=AFQjCNHEPzqK6kz4ZM6Evtlo42J2JhbRKA">torrent client</a> installed on your device.</p>
            	</div>
            </div>
        </div>

        <div id="fade" style="z-index: 11;display: none;  background: #000;  position: fixed;  left: 0;  top: 0;  width: 100%;  height: 100%;  opacity: .30;  z-index: 99999;"></div>     
	     <div id="loading" class="page-loader" style="display:none">	        
	     </div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
		        $('#example-getting-started').multiselect();
		    });
			$(document).ready(function(){

				// $('a[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').closest('div').hide();
				$( "#keyword" ).autocomplete({
			      source: function( request, response ) {
			        $.ajax( {
			          url: "api.php",
			          dataType: "jsonp",
			          data: {
			            term: request.term
			          },
			          success: function( data ) {
			            response( data );
			          }
			        } );
			      },
			      minLength: 2,
			      select: function( event, ui ) {
			        $("#keyword").val(ui.item.value);
			        getResult(1);
			      },
			      close: function( event, ui ) {
			      	// getResult(1);
			      }, 

			      search  : function(){$(this).addClass('ui-autocomplete-loading');},
				  open    : function(){$(this).removeClass('ui-autocomplete-loading');}
			    } );

				$('#keyword').on("keypress", function(e) {
		            /* ENTER PRESSED*/
		            if (e.keyCode == 13) {
		                // getResult(1);
		                var keyword = $("#keyword").val();
						window.location = '/searchTorrent/'+keyword;
		            }
		        });

		   
		   		$("#search").click(function()
				{
					// getResult(1);
					var keyword = $("#keyword").val();
					window.location = '/searchTorrent/'+keyword;
				});				

				getResult = function(page)
				{
					var orderBy = $('.btn-group button.active').data('value');					
					var keyword = $("#keyword").val();

					if( keyword == '' )
					{
						alert("Keyword cannot be blank");
						return false;
					}

					$("#fade").show();
					$("#loading").show();

					// $("#keyword").val('');

					$.ajax({
						url : 'getResult.php',
						data : { 'keyword': keyword, 'orderBy':orderBy, 'page':page },
						method : 'post',
						success : function(data)
						{
							$("#fade").hide();
							$("#loading").hide();
							$("#result_container").html(data);
							$("#keyword").val(keyword);
						}
					});
				}

				$(document).on('click', ".btn-group button", function()
				{
					$('.btn-group button').each(function(index, item){
						$(item).removeClass('active');
					});

					if( $(this).hasClass('active') )
					{
						$(this).removeClass('active');	
					}
					else
					{
						$(this).addClass('active');
					}

					getResult();
				});

				$(document).on('click', ".next", function()
				{					
					var nextCount = $(this).data('value');
					var page = parseInt($("#hidPageCount").val());
					page++;	

					if( nextCount != 0 )
					{
						getResult(page);	
					}										
					
				});

				$(document).on('click', ".prev", function()
				{
					var page = parseInt($("#hidPageCount").val());

					if(page == 1)
					{
						return false;
					}
					else{ 
						page--;
					}

					getResult(page);	
										
				});
				
			});
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-26827253-2', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>
