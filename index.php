<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>時計</title>
    <style>
        body {
            background-color: snow;
        }

        .display {
            display: inline-block;
            box-sizing: border-box;
            position: relative;
            width: 60px;
            height: 100px;
            border: solid 4px snow;
            background-color: snow;
            overflow: hidden;
        }

        .display::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 28px;
            height: 28px;
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .display::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 12px;
            border-top: solid 30px snow;
            border-bottom: solid 30px snow;
            transform: translate(-50%, -50%);
        }

        .d0::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px black,
                0px 30px black,
                30px 0px black,
                30px 30px black;
        }

        .d1::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px lavenderblush,
                0px -30px black,
                -30px 0px lavenderblush,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px lavenderblush;
        }

        .d2::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px lavenderblush,
                0px 30px black,
                30px 0px lavenderblush,
                30px 30px black;
        }

        .d3::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px lavenderblush,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px black;
        }

        .d4::before {
            background-color: black;
            box-shadow: -30px -30px lavenderblush,
                0px -30px black,
                -30px 0px black,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px lavenderblush;
        }

        .d5::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px lavenderblush,
                -30px 0px black,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px black;
        }

        .d6::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px lavenderblush,
                -30px 0px black,
                0px 30px black,
                30px 0px black,
                30px 30px black;
        }

        .d7::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px black,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px lavenderblush;
        }

        .d8::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px black,
                0px 30px black,
                30px 0px black,
                30px 30px black;
        }

        .d9::before {
            background-color: black;
            box-shadow: -30px -30px black,
                0px -30px black,
                -30px 0px black,
                0px 30px lavenderblush,
                30px 0px black,
                30px 30px black;
        }

        .d10 {
            width: 5px;
            height: 90px;
            border: solid 5px black;
            background-color: black;
            transform: rotate(20deg);
            margin-left: 15px;
            margin-right: 15px;
            margin-bottom: 5px;
        }

        .d10::after {
            border: solid 5px black;
        }

        .d11 {
            width: 20px;
            border: solid 4px snow;
            background-color: snow;
        }

        .d11::after {
            border: solid 30px gray;
        }

        .d12 {
            width: 30px;
            border: solid 4px snow;
            background-color: snow;
        }

        .d0.lm::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px tomato,
                0px 30px tomato,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d1.lm::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px lavenderblush,
                0px -30px tomato,
                -30px 0px lavenderblush,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px lavenderblush;
        }

        .d2.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px lavenderblush,
                0px 30px tomato,
                30px 0px lavenderblush,
                30px 30px tomato;
        }

        .d3.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px lavenderblush,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d4.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px lavenderblush,
                0px -30px tomato,
                -30px 0px tomato,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px lavenderblush;
        }

        .d5.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px lavenderblush,
                -30px 0px tomato,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d6.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px lavenderblush,
                -30px 0px tomato,
                0px 30px tomato,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d7.lm::before {
            background-color: lavenderblush;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px tomato,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px lavenderblush;
        }

        .d8.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px tomato,
                0px 30px tomato,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d9.lm::before {
            background-color: tomato;
            box-shadow: -30px -30px tomato,
                0px -30px tomato,
                -30px 0px tomato,
                0px 30px lavenderblush,
                30px 0px tomato,
                30px 30px tomato;
        }

        .d11.lm::after {
            border: solid 30px tomato;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function (event) {
            setInterval(clock, 1000)
        });

        function clock() {

            let body = document.querySelector('.clock');
            while (body.firstChild) {
                body.removeChild(body.firstChild);
            }
            let now = new Date();
            let yyyy = now.getFullYear();
            let mm = now.getMonth() + 1;
            let dd = now.getDate();

            let hh = now.getHours();
            let mi = now.getMinutes();
            let ss = now.getSeconds();

            let result = ('0' + hh).slice(-2) + ':' + ('0' + mi).slice(-2) + ':' + ('0' + ss).slice(-2);
            for (let i = 0, len = result.length; i < len; i++) {
                let div = document.createElement('div');
                div.classList.add('display');
                switch (result.charAt(i)) {
                    case '0': div.classList.add('d0');div.classList.add('lm'); break;
                    case '1': div.classList.add('d1');div.classList.add('lm'); break;
                    case '2': div.classList.add('d2');div.classList.add('lm'); break;
                    case '3': div.classList.add('d3');div.classList.add('lm'); break;
                    case '4': div.classList.add('d4');div.classList.add('lm'); break;
                    case '5': div.classList.add('d5');div.classList.add('lm'); break;
                    case '6': div.classList.add('d6');div.classList.add('lm'); break;
                    case '7': div.classList.add('d7');div.classList.add('lm'); break;
                    case '8': div.classList.add('d8');div.classList.add('lm'); break;
                    case '9': div.classList.add('d9');div.classList.add('lm'); break;
                    case '/': div.classList.add('d10'); break;
                    case ':': div.classList.add('d11'); break;
                    case ' ': div.classList.add('d12'); break;
                }
                body.appendChild(div);
            }
        }
    </script>
</head>

<body>
    <span>■現在時刻</span>
    <div class="clock"></div>


</body>

</html>