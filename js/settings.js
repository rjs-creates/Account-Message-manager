$ajaxURL = 'webservice.php';

$(document).ready(()=>{
    GetUsers();
    $('#submit').click(()=>
    {
        AddUser();
    })
})

function DeleteUser(obj)
{
    let sendData = {};
    sendData['action'] = 'DeleteUser';
    sendData['userID'] = obj;
    ajaxRequest($ajaxURL,'POST',sendData,'html',SuccessHandler,ErrorHandler);
}

function AddUser()
{
    let username = $('#userId').val();
    let pass = $('#passId').val();
    let sendData = {};
    sendData['action'] = 'AddUser';
    sendData['user'] = username;
    sendData['pass'] = pass;
    ajaxRequest($ajaxURL,'POST',sendData,'html',SuccessHandler,ErrorHandler);
}

function  GetUsers()
{
    let sendData = {};
    sendData['action'] = 'GetUsers';
    ajaxRequest($ajaxURL,'GET', sendData,'json',ShowUsers,ErrorHandler)
}

function SuccessHandler(data,ajaxStatus)
{
    $('#status').val(data['status']);
    GetUsers();
}

function ShowUsers(data,ajaxStatus)
{
    //$('#status').html(ajaxStatus);
    $('#userTable').find('tbody').empty();
    for(let i = 0; i < data['data'].length;i++)
    {
        let mytr = document.createElement("tr");
        for(let j = 0; j < 4;j++)
        {
            let mytd = document.createElement("td");            
            if(j == 0)
            {
                let node = document.createElement("button");
                $(node).prop({"value":`${data["data"][i]["userID"]}`,"class":"DeleteBtn"})
                $(node).html("Delete");
                mytd.appendChild(node);
            }
            else if(j==1)
            {
                let node = document.createTextNode(data["data"][i]["userID"]);
                mytd.appendChild(node);
            }
            else if(j==2)
            {
                let node = document.createTextNode(data["data"][i]["username"]);
                mytd.appendChild(node);
            }
            else if(j==3)
            {
                let node = document.createTextNode(data["data"][i]["password"]);
                mytd.appendChild(node);
            }
            mytr.appendChild(mytd);
        }
        $('#userTable').find('tbody').append(mytr);
    }

    $('.DeleteBtn').click( function () {
        DeleteUser(this.value);
    });
}

function ErrorHandler(data,ajaxStatus)
{
    $('#status').html(ajaxStatus);
    console.log(ajaxStatus);
}