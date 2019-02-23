<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            
        </style>
    </head>
    <body>
        <div class=" ">
            @foreach($groups as $key => $teams)
            <table >
                <tr>
                    <th colspan='4'>
                        Group {{$key}}
                    </th>   
                </tr>
                <tr>
                    <th>Name</th>  
                    <th>Strength</th>
                    <th>W</th>
                    <th>L</th>
                    <th>N/R</th>
                    <th>Points</th>
                </tr>
                @foreach($teams as $team)
                <tr>
                    <td>{{!empty($team->name)?$team->name:""}}</td>
                    <td>{{!empty($team->strength)?$team->strength:""}}</td>
                    <td>{{!empty($team->W)?$team->W:0}}</td>
                    <td>{{!empty($team->L)?$team->L:0}}</td>
                    <td>{{!empty($team->N)?$team->N:0}}</td>
                    <td>{{!empty($team->points)?$team->points:0}}</td>
                </tr>
                @endforeach
            </table>
            @endforeach
            <div class="content">
                <form id="play" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">    
                <button type="submit">Play</button>
                </form>
                
            </div>
            @if(!empty($fixtures) && count($fixtures)>0)
             <table>
                <tr>
                    <th colspan='4'>
                        FIXTURES
                    </th>   
                </tr>
                <tr>
                    <th>Home</th>  
                    <th>OPPONENT</th>
                    <th>ROUND</th>
                    <th>WINNER</th>
                    <th>Loss BY wickets</th>
                    <th>Loss BY Runs</th>
                    
                </tr>
                @foreach($fixtures as $fixture)
                <tr>
                    <td>{{array_get($fixture,'home.name','')}}</td>
                    <td>{{array_get($fixture,'opponent.name','')}}</td>
                     <td>{{array_get($fixture,'round','')}}</td>
                    <td>{{array_get($fixture,'winner.name','')}}</td>
                     <td>{{array_get($fixture,'loss_margin_wickets',0)}}</td>
                     <td>{{array_get($fixture,'loss_margin_score',0)}}</td>
                </tr>
                @endforeach
            </table>
           @endif 
        </div>
    </body>
</html>
