<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <style>
        td {
            border-bottom: 1px solid #ddd;
            margin: 5px;
        }
    </style>
    <body>
        <div>
            <div style="float: left;">
                <p>My Company<br/>
                My street address,<br/>
                Contact: email@mycompany.com
                </p>
            </div>
            <div style="float: right">
                <img style="width: 250px" src="{{ public_path('img\logo.png') }}">
            </div>
        </div>
        <div>
            <div style="text-align: center; padding-top: 130px;">
                <h1>RECEIPT</h1>
            </div>
        </div>
        <div>
            <div style="float: right">
                <p>Receipt for<br/>
                Rhys Hall<br/>
                hello@pinecode.io<br/>
                </p>
            </div>
            <div style="text-align: right">
                <p><br/>
                3rd May 2018<br/>
                Account ID: 12345
                </p>
            </div>
        </div>
        <div>
            <table cellspacing="1">
                <thead style="background-color: #eeeeee; border: none;">
                    <tr>
                        <th width="120px" height="35px" style="margin: 5px">Date</th>
                        <th width="220px">Description</th>
                        <th width="260px">Payment method</th>
                        <th width="118px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td height="45px">03/05/2018</td>
                        <td>Moneys for services</td>
                        <td>Mastercard **** **** **** 1234</td>
                        <td>$55.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>           