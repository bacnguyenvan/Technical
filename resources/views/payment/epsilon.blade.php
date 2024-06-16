<html>

<head>
    <style>
        TABLE.S1 {font-size: 9pt; border-width: 0px; background-color: #E6ECFA; font-size: 9pt;}
        TD.S1   {  border-width: 0px; background-color: #E6ECFA;color: #505050; font-size: 9pt;}
        TH.S1   {  border-width: 0px; background-color: #7B8EB4;color: #E6ECFA; font-size: 9pt;}
        TABLE {  border-style: solid;  border-width: 1px;  border-color: #7B8EB4; font-size: 8pt;}
        TD   {  text-align: center; border-style: solid;  border-width: 2px; border-color: #FFFFFF #CCCCCC #CCCCCC #FFFFFF; color: #505050; font-size: 8pt;}
        TH   {  background-color: #7B8EB4;border-style: solid;  border-width: 2px; border-color: #DDDDDD #AAAAAA #AAAAAA #DDDDDD; color: #E6ECFA; font-size: 8pt;}
    </style>
    <script>
        function switching(flag,flag2,flag3) {
            document.getElementsByName('conveni_code')[0].disabled=flag
            document.getElementsByName('user_name_kana')[0].disabled=flag
            document.getElementsByName('user_tel')[0].disabled=flag
            document.getElementsByName('mission_code')[0].disabled=flag3
            document.getElementsByName('process_code')[0].disabled=flag3
            document.getElementsByName('consignee_postal')[0].disabled=flag2
            document.getElementsByName('consignee_name')[0].disabled=flag2
            document.getElementsByName('consignee_pref')[0].disabled=flag2
            document.getElementsByName('consignee_address')[0].disabled=flag2
            document.getElementsByName('consignee_tel')[0].disabled=flag2
            document.getElementsByName('orderer_postal')[0].disabled=flag2
            document.getElementsByName('orderer_name')[0].disabled=flag2
            document.getElementsByName('orderer_pref')[0].disabled=flag2
            document.getElementsByName('orderer_address')[0].disabled=flag2
            document.getElementsByName('orderer_tel')[0].disabled=flag2
        }
        function init(){
            var funcItem = {}
            funcItem["normal"] = function(){ switching(true,false,false) }
            funcItem["card"] = function(){ switching(true,true,false) }
            funcItem["conveni"] = function(){ switching(false,true,true) }
            funcItem["atobarai"] = function(){ switching(true,false,true) }
            var items = document.getElementsByName('st');
            for( var i = 0; i < items.length; i++ ){
                if( items[i].checked ){
                    funcItem[items[i].value]();
                    return;
                }
            }
        }
    </script>
</head>

<body>
    <form action="{{route('payment-epsilon')}}" method="post">
        @csrf
        <table class="S1" width="400" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="S1">
                    <td class="S1">
                        <table class="S1" width="100%" cellpadding="6" align="center">
                            <tbody>
                                <tr class="S1">
                                    <th class="S1" align="left">Product purchase sample
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="S1" width="90%" align="center">
                            <tbody>
                                <tr class="S1">
                                    <td class="S1">
                                        Please select the item you want to purchase.
                                        <table cellspacing="4" cellpadding="4" align="left">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        Product name
                                                    </th>
                                                    <th>
                                                        price
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="item" value="mouse">
                                                        mouse
                                                    </td>
                                                    <td>
                                                        800 yen
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="item" value="keyboard">
                                                        keyboard
                                                    </td>
                                                    <td>
                                                        2980 yen
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br><br>
                                    </td>
                                </tr>
                                <tr class="S1">
                                    <td class="S1">
                                        <br>
                                        Please enter the following information<br>
                                        <table cellspacing="4" cellpadding="4" align="left">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        User ID
                                                    </td>
                                                    <td><input type="text" name="user_id" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        full name
                                                    </td>
                                                    <td><input type="text" name="user_name" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        email address
                                                    </td>
                                                    <td><input type="text" name="user_mail_add" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Payment Type
                                                    </td>
                                                    <td><label>
                                                        <input type="radio" name="st" value="normal"
                                                                onclick="switching(true,false,false)" checked="">
                                                                Not specified
                                                        </label>
                                                        　　<label><input type="radio" name="st" value="card"
                                                                onclick="switching(true,true,false)">
                                                                credit card payment
                                                        </label>
                                                        　　<label><input type="radio" name="st" value="conveni"
                                                                onclick="switching(false,true,true)">
                                                                Convenience store settlement
                                                        </label>
                                                        　　<label><input type="radio" name="st" value="atobarai"
                                                                onclick="switching(true,false,true)">
                                                                GMO Pay Later
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Convenience store code
                                                    </td>
                                                    <td><select name="conveni_code" disabled="">
                                                            <option value="0" selected="">-</option>
                                                            <option value="11">
                                                                Seven-Eleven
                                                            </option>
                                                            <option value="21">
                                                                Family Mart
                                                            </option>
                                                            <option value="31">
                                                                Lawson
                                                            </option>
                                                            <option value="32">
                                                                Seicomart
                                                            </option>
                                                            <option value="33">
                                                                Ministop
                                                            </option>
                                                            <option value="35">
                                                                Circle K
                                                            </option>
                                                            <option value="36">
                                                                thanks
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        User name (kana)
                                                    </td>
                                                    <td><input type="text" name="user_name_kana" value="" disabled="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        User Phone Number
                                                    </td>
                                                    <td><input type="text" name="user_tel" value="" disabled=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Destination postal code
                                                    </td>
                                                    <td><input type="text" name="consignee_postal" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Shipping address
                                                    </td>
                                                    <td>
                                                        <select name="consignee_pref">
                                                            <option value="11">
                                                                Hokkaido
                                                            </option>
                                                        </select>
                                                        <input type="text" name="orderer_address" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Orderer's name
                                                    </td>
                                                    <td><input type="text" name="orderer_name" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Orderer's phone number
                                                    </td>
                                                    <td><input type="text" name="orderer_tel" value=""></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Charge category
                                                    </td>
                                                    <td><select name="mission_code">
                                                            <option value="1" selected="">
                                                                One-time charge
                                                            </option>
                                                            <option value="21">
                                                                Recurring Charge 1
                                                            </option>
                                                            <option value="22">
                                                                Recurring Charges 2
                                                            </option>
                                                            <option value="23">
                                                                Recurring Charges 3
                                                            </option>
                                                            <option value="24">
                                                                Recurring Charges 4
                                                            </option>
                                                            <option value="25">
                                                                Recurring Charges 5
                                                            </option>
                                                            <option value="26">
                                                                Recurring Charges 6
                                                            </option>
                                                            <option value="27">
                                                                Recurring Charges 7
                                                            </option>
                                                            <option value="28">
                                                                Recurring Charges 8
                                                            </option>
                                                            <option value="29">
                                                                Recurring Charges 9
                                                            </option>
                                                            <option value="30">
                                                                Recurring Charges 10
                                                            </option>
                                                            <option value="31">
                                                                Recurring Charges 11
                                                            </option>
                                                            <option value="32">
                                                                Recurring Charges 12
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Processing division
                                                    </td>
                                                    <td><select name="process_code">
                                                            <option value="1" selected="">
                                                                First charge
                                                            </option>
                                                            <option value="2">
                                                                Registered Billing
                                                            </option>
                                                            <option value="3">
                                                                Registration only
                                                            </option>
                                                            <option value="4">
                                                                <font style="vertical-align: inherit;">
                                                                    <font style="vertical-align: inherit;">Change
                                                                        registration details</font>
                                                                </font>
                                                            </option>
                                                            <option value="7">
                                                                <font style="vertical-align: inherit;">
                                                                    <font style="vertical-align: inherit;">Cancellation
                                                                        of membership</font>
                                                                </font>
                                                            </option>
                                                            <option value="9">
                                                                <font style="vertical-align: inherit;">
                                                                    <font style="vertical-align: inherit;">Withdrawal
                                                                    </font>
                                                                </font>
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="S1">
                                    <td class="S1">
                                        <br>
                                        <input type="hidden" name="come_from" value="here">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;"><input type="submit" name="go"
                                                    value="Send 999"></font>
                                        </font>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

</body>

</html>