let ajaxURL = './svc/messages/';
$(document).ready(()=>{
    let filter = $('#filterId').val();
    GetMessages(filter);
    $('#Search').click(function(){GetMessages($('#filterId').val())});
    $('#Send').click(function(){InsertMessage($('#messageID').val())});
})

function InsertMessage(message)
{
    let sendData = {};
    ajaxRequest(ajaxURL+message,'POST',sendData,'html',ShowInsert,ErrorHandler)
}
function  GetMessages(filter)
{   
    let sendData = {};
    ajaxRequest(ajaxURL+filter,'GET', sendData,'json',ShowMessages,ErrorHandler)
}

function DeleteMessage(msgId)
{
    let sendData = {};
    ajaxRequest(ajaxURL+msgId,'DELETE',sendData,'html',ShowDelete,ErrorHandler);
}

function ShowMessages(data,ajaxStatus)
{
    $('#status').html(data["status"]);
    $('#messageTable').find('tbody').empty();
    for(let i = 0; i < data['data'].length;i++)
    {
        let mytr = document.createElement("tr");
        for(let j = 0; j < 5;j++)
        {
            let mytd = document.createElement("td");            
            if(j == 0)
            {
                let node = document.createElement("button");
                $(node).prop({"value":`${data["data"][i]["messageID"]}`,"class":"DeleteBtn"})
                $(node).html("Delete");
                mytd.appendChild(node);
            }
            else if(j==1)
            {
                let node = document.createTextNode(data["data"][i]["messageID"]);
                mytd.appendChild(node);
            }
            else if(j==2)
            {
                let node = document.createTextNode(data["data"][i]["username"]);
                mytd.appendChild(node);
            }
            else if(j==3)
            {
                let node = document.createTextNode(data["data"][i]["message"]);
                mytd.appendChild(node);
            }
            else
            {
                let node = document.createTextNode(data["data"][i]["messageTime"]);
                mytd.appendChild(node);
            }
            mytr.appendChild(mytd);
        }
        $('#messageTable').find('tbody').append(mytr);
    }

    $('.DeleteBtn').click( function () {
        DeleteMessage(this.value);
    });
}

function ShowInsert(data,ajaxStatus)
{
    $('#AddStatus').html(data+" new line added");
    GetMessages("");
}

function ShowDelete(data ,ajaxRequest)
{
    $('#AddStatus').html(data+" line removed");
    GetMessages("");
}

function ErrorHandler(data,ajaxStatus)
{
    $('#status').html(ajaxStatus);
    console.log(ajaxStatus);
}