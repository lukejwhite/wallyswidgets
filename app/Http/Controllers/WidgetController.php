<?php

namespace App\Http\Controllers;

use App\Models\Widget;

use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * Count out Widgets
     * 
     * @param int $number
     * @return json response
     */
    public function countWidgets(Request $request)
    {
        $widgets = $request->widgets; //get some widgets to count

        //fetch the widget packs from the database 
        $availablePacks = Widget::select('pack_size', 'cost')->get()->sortBy('pack_size')->toArray();
        $availablePacks = array_merge( [['pack_size' => 0, 'cost' => "0.00"]], $availablePacks );
        
        //count out packs for use in later for loop
        $numberOfPacks = count( $availablePacks );

        //save the lowest value for comparisons in for loop
        $lowest = $availablePacks[1]['pack_size'];

        $recommendedOrder = [];

        while($widgets > 0)
        {
        
            for($i=0; $i < $numberOfPacks; $i++)
            {
                //isset($availablePacks[$i + 1] is to stop the warning caused by attempting to access array with to high a key
                if(isset($availablePacks[$i + 1]) && 
                    ( $widgets > $availablePacks[$i]['pack_size'] && $widgets <= $availablePacks[$i+1]['pack_size'] ) //check if remainder equal or between pack sizes
                ){
                    //check to see if a combinations of smaller packs will be suitable
                    if( $widgets <= ($availablePacks[$i + 1]['pack_size'] - $lowest) )
                    {
                        array_push( $recommendedOrder, $availablePacks[$i] ); //add pack to order
                        $widgets -= $availablePacks[$i]['pack_size']; //remove widgets from running total that are in the pack
                        continue;
                    } else {
                        array_push( $recommendedOrder, $availablePacks[$i+1] );
                        $widgets -= $availablePacks[$i+1]['pack_size'];
                        continue;
                    }
                    
                }
                
            }
        
            if( $widgets > $availablePacks[$numberOfPacks - 1]['pack_size'] ) //add the biggest pack if needed
            {
                array_push( $recommendedOrder, $availablePacks[$numberOfPacks - 1] );
                $widgets -= $availablePacks[$numberOfPacks - 1]['pack_size'];
                continue;
            }
        }

        return $recommendedOrder;
    }
}
