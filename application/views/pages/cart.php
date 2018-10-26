<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            input {text-align:right}
        </style>
        <script>
         function updateTotal() {
             var numapples = document.getElementById("numapples").value;
             var numoranges = document.getElementById("numoranges").value;
             var numbananas = document.getElementById("numbananas").value;
             var total = numapples*0.99 + numoranges*0.49 + numbananas*0.79;
             document.getElementById("total").value = total;
         }    
        </script>
    </head>
    <body>
        <form>
        <table>
            <tr>
                <td>Apples (0.99)</td><td><input id="numapples" name="numapples" onkeyup="updateTotal();" /></td></tr>
            </tr>
            <tr>
                <td>Oranges (0.49)</td><td><input id="numoranges" name="numoranges" onkeyup="updateTotal();" /></td></tr>
            </tr>
            <tr>
                <td>Bananas (0.79)</td><td><input id="numbananas" name="numbananas" onkeyup="updateTotal();" /></td></tr>
            </tr>
            <tr>
                <td>Total:</td>
                <td><input id="total" readonly="readonly" /></td>
            </tr>
            <tr><td colspan="2"><input type="submit" value="Buy" /></tr>
        </table>
        </form>
    </body>
</html>
