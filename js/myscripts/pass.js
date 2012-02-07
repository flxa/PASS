// Check ALL
	$(document).ready(function(){
		$('#check-all').toggle(function(){
			$('.check-able').attr('checked','checked');
        	$(this).val('uncheck all')
		},function(){
        	$('.check-able').removeAttr('checked');
        	$(this).val('check all');        
		})
	})

  	// delete address
  	$(document).ready(function(){
		$('#delete-item').click(function(){
			var ids = $('.check-able:checked');
			if (ids.length>1 || ids.length<1) { var iname = "items"; } else { var iname = "item"; }
			if (ids.length>0) {
				var answer = confirm("Are you sure you wish to delete "+ids.length+" "+iname+"?");
				if (answer) {
					$("form").submit();
				} else {
					alert("No items have been deleted!");
				}
			} else {
				alert("You have selected "+ids.length+" "+iname+". Please check the lines that you wish to delete!");
			}
			//request;
  		});
  	});

  	

	// fade login message
	$(document).ready(function(){
		$('.message-fade').delay(1600).fadeOut(1600);
	});

	// update range value display
	$(document).ready(function(){
		$('#range-in').change(function(){
			$('#range-out').text('$'+addCommas(this.value)); // = $('#range-in').value();
		});
	});

	// focus search
	$(document).ready(function(){
		$('.dd-search').click(function(){
			$('input#main-search').focus();
		});
	});

	// Write Browser Details to hidden div
	$(document).ready(function(){
		var e = window
		, a = 'inner';
		if ( !( 'innerWidth' in window ) ) {
			a = 'client';
			e = document.documentElement || document.body;
		}
		var viewport = ' Width : '+e[ a+'Width' ]+', Height : '+e[ a+'Height' ];
		$('.browser-details').append('<br />Viewport:'+viewport);
	});

	$(document).ready(function(){
		$('.layout-icon').click(function(){
			$('.browser-details').toggle();
		});
	});	

	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function viewport() {
		var e = window
		, a = 'inner';
		if ( !( 'innerWidth' in window ) ) {
			a = 'client';
			e = document.documentElement || document.body;
		}
		return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
	}

	// Loadmore
	$(document).ready(function(){
		$('#loadmore').click(function(){
			var Company_ID = $("input#Company_ID").val();
			var Opp_LimitStart  = parseInt($("input#Opp_LimitStart").val());
			var dataString = 'type=loadMoreOpps&Company_ID='+ Company_ID +'&Opp_LimitStart='+ Opp_LimitStart; 
			//alert(dataString);
			$.ajax({
				type: "POST",
				url: "raw.php",
				data: dataString,
				beforeSend: function() { 
					$('#loadmore').html('<span class="spinner">&nbsp;</span>');
				},
				success: function(data) {
					//alert(Opp_LimitStart);
					$('#opportunities').append(data);
					$('#Opp_LimitStart').val(Opp_LimitStart+5);
				}
			}).done(function( msg ) {
				$('#loadmore').html('Load More');
				var highestRow=parseInt($('#opportunities tr').last().attr('id').substr(2));
				//alert(highestRow);
				if (highestRow<Opp_LimitStart+5) {
					//$('#loadmore').addClass('disabled');
					$('#loadmore').fadeOut('slow');
				} else {
					//alert( Opp_LimitStart+5);
				}
			});
		});
	});


