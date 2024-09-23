@props(['icons' => '', 'links' => '', 'titles' => ''])
<aside>
   <div class="items-container">
       <a href="https://www.fae.br/unifae2/" target="_blank">
           <img class="logo" src="https://www.fae.br/unifae2/wp-content/uploads/2022/01/1625239632883-logo-unifae-2021-branca.png" alt="">
            <p>EMBAIXADORES</p>
       </a>
       <div class="link-container"> @foreach($titles as $i => $title)
               <a class="link-item" href="{{route($links[$i])}}">
                   <i class="{{$icons[$i]}}"></i>
                   {{$title}}
               </a>
           @endforeach
       </div>

   </div>
</aside>