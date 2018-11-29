$(document).ready(function() {
    // $('#example-getting-started').multiselect();
});
$(document).ready(function(){

	// $('a[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').closest('div').hide();
	$( "#keyword" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "/api.php",
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
        window.location = '/searchTorrent/'+encodeURI(ui.item.value);
        // getResult(1);
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
			window.location = '/searchTorrent/'+encodeURI(keyword);
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
			url : '/getResult.php',
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