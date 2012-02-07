// save modal form
	$(document).ready(function(){
		// First modal on page uses this function
		$('#save-ajax').click(function(){
			var ajax_type = $("input#AjaxType").val();
			switch(ajax_type) {
				case 'company':
					var Company_Name = $("input#Company_Name").val();  
					var dataString = 'type=SaveCompany&Company_Name='+ Company_Name; 
					$.ajax({
						type: "POST",
						url: "raw.php",
						data: dataString,
						success: function(data) {
							$('#mod-body').html("<div id='message'></div>");
							$('#message').html("<h2>Account Created!</h2><p>After completing the client details you should edit the Account and complete the rest of the details</p>");
							$('#save-ajax').hide();
							//alert(data);
							var dataString2 = 'type=CompanySelectList&id='+data;
							//alert(datastring2);
							$.ajax({
								type: "POST",
								url: "raw.php",
								data: dataString2,
								success: function(data2) {
									$('#CCI').replaceWith(data2);
								}
							});
						}
					});
				break;
				case 'market-segment':
					var Market_Segment = $("input#Company_MarketSegmentName").val();
					var dataString = 'type=SaveMarketSegment&Company_MarketSegmentName='+ Market_Segment; 
					if (Market_Segment!='') {
						$.ajax({
							type: "POST",
							url: "raw.php",
							data: dataString,
							success: function(data) {
								$('#mod-body').html("<div id='message'></div>");
								$('#message').html("<h2>Market Segment Created!</h2>");
								$('#save-ajax').hide();
								var dataString2 = 'type=MarketSegmentSelectList&id='+data;
								$.ajax({
									type: "POST",
									url: "raw.php",
									data: dataString2,
									success: function(data2) {
										$('#CMS').replaceWith(data2);
									}
								});
							}
						});
					} else {
						alert("You must enter a Name for the Market Segment!");
					}
				break;
				
			}
			return false;

		});
		// Second Modal on Page uses this function
		$('#save-ajax-2').click(function(){
			var ajax_type = $("input#AjaxType-2").val();
			switch(ajax_type) {
				case 'client-role':
					var Client_RoleName = $("input#Client_RoleName").val();
					var dataString = 'type=SaveClientRole&Client_RoleName='+ Client_RoleName; 
					if (Client_RoleName!='') {
						$.ajax({
							type: "POST",
							url: "raw.php",
							data: dataString,
							success: function(data) {
								$('#mod-body-2').html("<div id='message-2'></div>");
								$('#message-2').html("<h2>Client Role Created!</h2>");
								$('#save-ajax-2').hide();
								var dataString2 = 'type=ClientRoleList&id='+data;
								$.ajax({
									type: "POST",
									url: "raw.php",
									data: dataString2,
									success: function(data2) {
										$('#CRI').replaceWith(data2);
									}
								});
							}
						});
					} else {
						alert("You must enter a Name for the Client Role!");
					}
				break;
				
			}
			return false;

		});

		$('#close-modal').click(function(){
			$('#modal-from-dom').modal('hide');
		});
		// This was required as I am using ID's and need to have 2 modals available for 1 screen
		$('#close-modal-2').click(function(){
			$('#modal-from-dom-2').modal('hide');
		});
	});