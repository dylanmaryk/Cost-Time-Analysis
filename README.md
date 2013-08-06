#booleans

tfl has an unusual method of indicating true and false in attrbutes. The xml uses 
the presence of an attribute with the value 0 to indicate true and absence of the 
attribute to indicate false.


#Session ID's
it appears that &sessionID=0 is required to have working links in the TFL route
view.

http://journeyplanner.tfl.gov.uk/user/XSLT_TRIP_REQUEST2?language=en&place_origin=London&place_destination=London&type_origin=locator&name_origin=AL2+1AE&type_destination=locator&name_destination=SW1H+0BD

http://journeyplanner.tfl.gov.uk/user/XSLT_TRIP_REQUEST2?language=en&execInst=&sessionID=0&ptOptionsActive=1&itOptionsActive=1&imparedOptionsActive=1&ptAdvancedOptions=1&place_origin=London&place_destination=London&show_origin=AL2+1AE&show_destination=SW1H+0BD&type_origin=locator&type_destination=locator&itdTripDateTimeDepArr=dep&datepicker=Today&stepfree-access=no-requirements&routeType=LEASTTIME&includedMeans=checkbox&inclMOT_2=on&inclMOT_1=on&inclMOT_5=on&inclMOT_0=on&inclMOT_4=on&inclMOT_9=on&inclMOT_7=on&inclMOT_8=on&inclMOT_3=on&trITMOTvalue101=60&trITMOTvalue=20&trITMOT=100&changeSpeed=normal&name_origin=AL2+1AE&name_destination=SW1H+0BD&itdDate=20130806&itdTimeHour=14&itdTimeMinute=16

http://journeyplanner.tfl.gov.uk/user/XSLT_TRIP_REQUEST2?language=en&sessionID=0&place_origin=London&place_destination=London&type_origin=locator&name_origin=AL2+1AE&type_destination=locator&name_destination=SW1H+0BD

#Detail view
You can find the detail vue by adding this to the URI:
&tripSelector3=1&itdLPxx_view=detail

note that &tripSelector1 should be added for the 1st route, &tripSelector2 for
the second, etc. As per Booleans, above.