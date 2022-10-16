function addRecord()
{
    var formData = new FormData(document.getElementById("formAdd"));
    $.ajax({
        url: 'clientes.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            alertModal(data.message);
            readRecords();
        },
        cache: false,
        contentType: false,
        processData: false
    });
};

function readRecords()
{
    $.get("clientes.php", {}, function(data, status)
    {
        var table = jsonToTable(data);
        const divShowData = document.getElementById('records_content');
        divShowData.innerHTML = "";
        divShowData.appendChild(table);
    });
}

function getClienteSingle(event)
{
    var clienteSearch = $('#clienteSingle input[name="clienteSingle"]').val();
    $.get("clientes.php", {
            clienteSearch: clienteSearch
        },
        function(data, status) {
            var table = jsonToTable(data);

            const divShowData = document.getElementById('records_content');
            divShowData.innerHTML = "";
            divShowData.appendChild(table);
        }
    );
}

function jsonToTable(dataObject)
{
    let col = [];
    for (let i = 0; i < dataObject.length; i++)
    {
        for (let key in dataObject[i])
        {
            if (col.indexOf(key) === -1)
            {
                col.push(key);
            }
        }
    }

    const table = document.createElement("table");
    table.classList.add("table");

    let tr = table.insertRow(-1);

    for (let i = 0; i < col.length; i++)
    {
        let th = document.createElement("th");
        th.innerHTML = col[i];
        tr.appendChild(th);
    }

    for (let i = 0; i < dataObject.length; i++)
    {
        tr = table.insertRow(-1);
        for (let j = 0; j < col.length; j++)
        {
            let tabCell = tr.insertCell(-1);
            var cell = dataObject[i][col[j]];
            if (cell.indexOf('data:image/') > -1)
            {
                cell = "<img class='foto img-thumbnail' src='" + cell + "' />";
            };
            tabCell.innerHTML = cell;
        }
    }

    return table;
}

function alertModal(message)
{
    $("#add_new_record_modal").modal("hide");
    $("#add_new_record_modal input:not(#token)").val("");
    $("#alertModal .modal-body p").html('');
    $("#alertModal .modal-body p").html(message);
    $("#alertModal").modal("show");
}

$(document).ready(function()
{
    readRecords();
});