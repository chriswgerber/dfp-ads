/**
 * Javascript for Google Ads
 *
 **/
/**
 * Prototype for Ad object coming from server
 *
 * @type {
 *          {
 *          account_id: string,
 *          div_id: string,
 *          roadblock_id: string,
 *          positions: {
 *              ad_name: string,
 *              out_of_page: boolean,
 *              position_tag: string,
 *              sizes: *[]
 *              }
 *          []
 *          }
 *      }
 */
var dfp_ad_data_proto = {
    // DFP Account ID
    'account_id' : '',
    // Div ID to associate with slot.
    'div_id' : '',
    // ID for Roadblock Ad
    'roadblock_id' : '',
    'page_targeting' : {
        'Page' : [],
        'Category' : [],
        'Tag' : []
    },
    // Ad Positions generated in code
    'positions': [
        {
            'ad_name': '',
            'out_of_page': false,
            'position_tag': '',
            'sizes': [
                [1, 1],
                [640, 430]
            ]
        },
        {
            'ad_name': '',
            'out_of_page': false,
            'position_tag': '',
            'sizes': [
                [1, 1],
                [640, 430]
            ],
            'targeting' : {
                'key' : 'value'
            }
        }
    ]
};

/**
 * Ad Position Creation
 */
googletag.cmd.push(function() {
    // Object from Ajax
    var dfp_ad_data = dfp_ad_object[0],
        acct_id = dfp_ad_data.account_id;
    /**
     * Loads Ad Position
     *
     * @param {Array} positions - Array of ad positions
     */
    function load_ad_positions(positions) {
        // Run through positions
        for (var ad_pos in positions) {
            define_ad_slot(positions[ad_pos]);
        }
    }
    // Generates Ad Slots
    load_ad_positions(dfp_ad_data.positions);
    // Enable Single Request
    googletag.pubads().enableSingleRequest();
    // Targeting
    set_targeting(dfp_ad_data.page_targeting);
    // Collapse Empty Divs
    googletag.pubads().collapseEmptyDivs(true);
    googletag.pubads().enableAsyncRendering();
    // Go
    googletag.enableServices();
    /**
     * Loads Ad Position
     *
     * @param {Object} position - Array of ad positions
     */
    function define_ad_slot(position) {
        googletag.defineSlot(
            acct_id + position.ad_name,
            position.sizes,
            position.position_tag
        ).addService(googletag.pubads());
        if (position.out_of_page === true) {
            googletag.defineOutOfPageSlot(
                acct_id + position.ad_name,
                position.position_tag + '-oop'
            ).addService(googletag.pubads());
        }
    }
    /**
     * Sets Page level targeting
     * @param {object} targeting
     */
    function set_targeting(targeting) {
        for (var target in targeting) {
            googletag.pubads().setTargeting(target, targeting[target]);
        }
    }
});
