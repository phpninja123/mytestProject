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
            	<div class="gcse-searchbox" data-resultsUrl="www.adfreetorrents.com/search.php"
data-newWindow="true" data-queryParameterName="keyword" >
                <div class="input-group">
                	
                    <script>
					  (function() {
					    var cx = '017165728399808114268:kkmzdcx9ei0';
					    var gcse = document.createElement('script');
					    gcse.type = 'text/javascript';
					    gcse.async = true;
					    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
					    var s = document.getElementsByTagName('script')[0];
					    s.parentNode.insertBefore(gcse, s);
					  })();
					</script>
					<gcse:search></gcse:search>
                </div>
            </div>

            

            <div id="result_container"></div>
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
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript">
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
		                getResult(1);
		            }
		        });

		   
		   		$("#search").click(function()
				{
					getResult(1);
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

					$("#keyword").val('');

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