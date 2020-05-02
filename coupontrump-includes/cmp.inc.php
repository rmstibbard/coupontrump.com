<script>
    var commandQueue = [];
    var cmp = function(command, parameter, callback) {
        commandQueue.push({
            command: command,
            parameter: parameter,
            callback: callback
        });
    };
    cmp.commandQueue = commandQueue;
    cmp.
    config: {       
        // customPurposeListLocation: '',
        layout: footer,
            storePublisherData: false,
                storeConsentGlobally: true,
                    l
        ogging: false,
            localization: {},
                forceLocale: null,
                    gdprAppliesGlobally: false,
                        repromptOptions: {           
                            fullConsentGiven: 360,
                                someConsentGiven: 30,
                                    noConsentGiven: 30,
                        },
                            geoIPVendor: '
                            https://cdn.digitrust.mgr.consensu.org/1/geoip.json
                            '
                                ,
                                testingMode: 'normal'   
                        }
        ;
        window.__cmp = cmp;
</script>
<script src
        =
        '
         https://cdn.digitrust.mgr.consensu.org/1/cmp.complete.bundle.js
         ' async> 
</script>


<!-- button onclick = "window.__cmp('showConsentTool')"> Revisit Consent Settings</button -->