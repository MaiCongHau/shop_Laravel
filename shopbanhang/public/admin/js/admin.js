function checkAll(check_all) {
	$(check_all).change(function() {
	    var checkboxes = $(this).closest('table').find(':checkbox');
	    checkboxes.prop('checked', $(this).is(':checked'));
	});
}
$(function(){
	$(".province").change(function (e) { 
		var province_id = $(this).val();
		if(!province_id)
		{
			updateSelectBox(null,".district");
			updateSelectBox(null,".ward");
		}

		$.ajax({
			url: `/admin/product/customer/${province_id}/district`,
		}).done(function (data){
			updateSelectBox(data,".district");
		});
	});
	$(".district").change(function (e) { 
		var  district_id = $(this).val();
		if(!district_id)
		{
			updateSelectBox(null,".ward");
		}
		$.ajax({
			url: `/admin/product/customer/${district_id}/ward`,
		}).done(function (data){
			updateSelectBox(data,".ward");
		});
	});
});


function updateSelectBox(data, selector)
{
	var items = JSON.parse(data);
	$(selector).find('option').not(':first').remove();
	if(!data) return;
	for(let i=0 ; i< items.length;i++)
	{
		// <option value="">Tỉnh / thành phố</option>
		let item = items[i];
		let option =  '<option value="' +item.id+ '">'+ item.name +'</option>'
		$(selector).append(option);
	}
}
