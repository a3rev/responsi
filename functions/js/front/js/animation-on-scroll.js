function scrollWaypointInit(items, trigger) {
	items.each(function() {
		var element = jQuery(this),
			osAnimationClass = element.data("animation"),
			trigger = trigger ? trigger : element;

		trigger.waypoint(
			function() {
				element.addClass("animated").addClass(osAnimationClass);
			},
			{
				triggerOnce: true,
				offset: "100%"
			}
		);
	});
}
//Call the init
jQuery(document).ready(function() {
	scrollWaypointInit(jQuery(".animateMe"));
});
