( function( api ) {
	// Extends our custom "polity-lite" section.
	api.sectionConstructor['polity-lite'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );
} )( wp.customize );