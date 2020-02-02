var buff = new Object();
window.onload = test();

function test(){
    id_inp = document.createElement('input');
    id_inp.type = 'text';
    id_inp.name = 'id_inp';
    id_inp.style.width = '20px';
    id_inp.id = 'id_inp';
    buff.id_inp = id_inp;
    buff.id = 0;
    document.forms.test.onsubmit = function(ob){submit(ob)};
    document.getElementById('butt').onclick = function(ob){submit2(ob)};
    document.getElementById('butt1').onclick = function(ob){ ob.preventDefault();id_get();};
    document.getElementById('butt2').onclick = function(ob){ob.preventDefault();tag_get();}
    load_msg();
}
function load_msg(){
    var data = new FormData();
    data.append('addData', 'load_msg');
    ans = JSON.parse(send(data));
    console.log(ans);
    for(i=0; i<ans.length;i++){
        msg = ans[i];
        console.log(i);
        if(msg.id == buff.id || buff.id == 0){
            console.log(i + ' +');
            if(buff.id == 0){buff.msg_arr = new Array();}
            buff.id = msg.id;
            buff.msg_arr[buff.msg_arr.length] = msg.msg;
        }
        else{
            console.log(i + ' -');
            msg1 = ans[i-1];
            var txt = create_msg(msg1.name[1], msg1.name[0], '00:00', buff.msg_arr);
            document.getElementsByClassName('msgs')[0].appendChild(txt);
            buff.id = 0;
            delete buff.msg_arr;
            i = i-1;
        }
        if(i==(ans.length-1)){
            console.log(i + ' -');
            if(i==0){
                msg1 = ans[i];
            }
            else{
                msg1 = ans[i-1];
            }
            var txt = create_msg(msg1.name[1], msg1.name[0], '00:00', buff.msg_arr);
            document.getElementsByClassName('msgs')[0].appendChild(txt);
            return;
        }
    }
}
function create_msg(im_src, name, time, msg_arr){
    var msg = document.createElement('div');
    msg.className = 'msg';
        var msg_photo = document.createElement('div');
        msg_photo.className = 'msg_photo';
            var img = document.createElement('img');
            img.className='avatar';
            img.src = im_src;
        msg_photo.appendChild(img);
    msg.appendChild(msg_photo);
        var msg_info = document.createElement('div');
        msg_info.className = 'msg_info';
            var a_name = document.createElement('a');
            a_name.innerText = name;
            var span_time = document.createElement('span');
            span_time.innerText = time;
        msg_info.appendChild(a_name);
        msg_info.appendChild(span_time);
    msg.appendChild(msg_info);
        var ul = document.createElement('ul');
        ul.className = 'msg_msg';
        for(i=0;i<msg_arr.length; i++){
            var li = document.createElement('li');
            li.className = 'msg_txt';
            li.innerText = msg_arr[i];
            ul.appendChild(li); 
        }
    msg.appendChild(ul);
    return msg;
}
function submit(ob){
    ob.preventDefault();
    //console.log(this);
    var data = new FormData(document.forms.test);
    data.append('addData', 'reg');
    console.log(data)
    var ans = send(data);
    console.log(ans);
    ans = ans.toString();
    var ans = JSON.parse(ans);
    console.log(ans);
    ans_p(ans);
}
function submit2(ob){
    ob.preventDefault();
    form = document.forms.mess;
    console.log(form);
    form.msg.value = document.getElementsByClassName('texts')[0].children[0].value;
    var data = new FormData(form);
    data.append('addData', 'msg');
    if(!form.id_inp){
        data.append('id_inp', buff.id_inp.value);
    }
    console.log(data);
    ans = JSON.parse(send(data));
    console.log(ans);
    if('miss' in ans){
        missing(ans.miss);
    }
}
function id_get(){
    console.log('fdfdf')
    if(document.getElementById('id_inp')) var key = 1;
    else var key = 0;
    console.log(key)
    switch(key){
        case 0:
        div = document.createElement('div');
        div.appendChild(buff.id_inp);
        div.style.opasity = '50%';
        div.style.position = 'absolute';
        div.style.top = '-16px';
        div.style.right = 0;
        document.getElementsByClassName('texts')[0].appendChild(div);
        break;
        case 1:
        document.getElementById('id_inp')
        var div = document.getElementById('id_inp').parentElement;
        div.parentElement.removeChild(div);
    }
}   
function tag_get(){
    if(document.getElementById('butt3')) var key = 1;
    else var key = 0;
    switch(key){
        case 0:
        var but = document.createElement('button');
        but.innerText = '+';
        but.className = 't_msg';
        document.getElementById('butt2').style.right = '60px';
        but.id = 'butt3';
        but.onclick = function(ob){ob.preventDefault();l = document.getElementsByClassName('tags').length;
        add_tag(l);};
        document.getElementsByClassName('texts')[0].appendChild(but);
        add_tag(0);
        break;
        case 1:
        buff.tags = document.getElementsByClassName('tags');

    }
}
function add_tag(y){
    var inp = document.createElement('input');
    inp.type = 'text';
    inp.name = 'tag'+y;
    inp.className = 'tags';
    var top = -20+(y*(-20));
    //console.log(top);
    inp.style.top = top + 'px';
    document.getElementsByClassName('texts')[0].appendChild(inp);
}
function ans_p(ans){
    if('miss' in ans){
        console.log(ans);
        console.log(ans.miss)
        missing(ans.miss);
    }
    if('success' in ans){
        console.log('d')
        f = document.forms.test;
        for(i=0;i<f.length;i++){
            if(f[i].classList.contains('button')) continue;
            f[i].value = '';
        }
        var id = document.createElement('div');
        id.innerHTML = 'Ваш ID:<span id="id"></span>';
        id.style.display = 'inline-block';
        console.log(id);
        f.appendChild(id);
        document.getElementById('id').innerText = ans.id;
        buff.id_inp.value = ans.id;
        if (document.getElementById('butt1')){
            document.getElementById('butt1').parentNode.removeChild(document.getElementById('butt1'));
        }
    }
}
function missing(m){
    if(m!='file'){
        alert('Не все поля заполнены');
    }
    else{
        alert('Картинка отсутствует');
    }
}
function send(data){
    var request = new XMLHttpRequest(); 
    request.open("POST", 'phptest.php', false);
    request.send(data);
    console.log(request)
    return request.responseText;
}