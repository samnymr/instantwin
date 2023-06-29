jQuery(document).ready(function($) {
// 	if($("body").hasClass("woocommerce-order-received") && Cookies.get("refreshed") != "1") {
// 		Cookies.set("refreshed", "1");
// 		window.location.reload(true);
// 	} else {
// 		Cookies.set("refreshed", "0");
// 	}

// 	setInterval(() => {
// 		$(".cc-expires").each(function() {
// 			const expires = new Date($(this).data("expires") * 1000),
// 				  now = new Date(),
// 				  diff = expires - now,
// 				  days = Math.floor(diff / 86400000),
// 				  hours = Math.floor((diff % 86400000) / 3600000),
// 				  minutes = Math.floor(((diff % 86400000) % 3600000) / 60000),
// 				  seconds = Math.floor((((diff % 86400000) % 3600000) % 60000) / 1000);
// 			if(days > 0) {
// 				$(this).text(`${days} days`);
// 			} else {
// 				$(this).text(`${hours}:${minutes}:${seconds}`);
// 			}
// 		})
// 	}, 1000)
	
	const queue = [];
	$(".winning-ticket-instant").each(function() {
		queue.push({title: "Instant prize won!", text: $(this).text(), icon: "success"});
	});
	if (queue.length == 1) {
			swal(queue[0]);
		} else if (queue.length > 0) {
			let s = swal(queue[0]);
			queue.forEach((v, i) => {
				if(i != 0) {
					s = s.then(async () => { await swal(v); });
				}
			});
		}
})