<x-app-layout>
    <x-slot name="header">
        <!--<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bo rr rd') }}
        </h2>-->
        <div class="container">
            <div id="app">
                <div class="count">
                    <small> Ce vote sera clos dans ... </small>
                    <p id="demo"> </p>
                </div>
                <div class="ooo">
                    <card title="ANGELO DE LA MAISON" description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo
                            quod, id, quidem beatae autem quam accusamus,necessitatibus cumque quos dolorem ex. At!" img_path="{{ URL('images/user.jpg') }}"></card>
                </div>
                <button onclick="start()"> Commencer </button>
            </div>
        </div>
    </x-slot>



    <style>
        .count {
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 5px 8px #ccc;
            margin: 30px 20px;
            border: 1px solid transparent;
            border-radius: 10px;
            height: 103px;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        #demo {
            transform: translateY(-6px);
            font-size: 3rem;
        }

        .ooo {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        @media screen and (max-width: 1000px) {
            .ooo {
                display: grid;
                grid-template-columns: 1fr;
            }
        }

    </style>

    <script>
        let countDownDate = new Date("June 28, 2022 20:00:00").getTime();

        function start() {
            let x = setInterval(function() {

                let now = new Date().getTime();

                let distance = countDownDate - now;

                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                    minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
            }, 1000);
        }

    </script>


</x-app-layout>
