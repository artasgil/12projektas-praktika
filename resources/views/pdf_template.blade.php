
        <style>
            .styled-table {
                border-collapse: collapse;
                margin: 5px 0;
                font-size: 0.9em;
                font-family: dejavu serif;
                font-size: 13px;
                width: 100%;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            }

            .styled-table thead tr {
                background-color: #009879;
                color: #ffffff;
                text-align: left;

            }

            .styled-table th,
            .styled-table td {
                padding: 10px 10px;
                border: 2px solid #000000;
                text-align: left;
            }

            .styled-table tbody tr:nth-of-type(even) {
                background-color: #f3f3f3;
            }
        </style>
        <table class="styled-table">
            <thead>
            <tr>
                <th width="20px"> ID </th>
                <th width="20px">Title</th>
                <th width="100px">Description</th>
                <th width="100px"> Price </th>
                <th width="100px"> Category Title </th>
                <th width="100px"> Product shop title </th>
            </tr>
        </thead>

            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }} </td>
                    <td>{{ $product->title }} </td>
                    <td>{!! $product ->description !!} </td>
                    <td>{{ $product ->price}} $</td>
                    <td>{{ $product->productCategory->title }}</td>
                    <td>{{ $product->productCategory->shopTitle->title }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
