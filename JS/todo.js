
/*todoのカウントダウンーーーーーーーーーーーーーーーーーーーーーーーーーーー*/
let countdown1 = setInterval(function(){
document.querySelectorAll('.countdown').forEach(function (elem) {
const now = new Date();  //今の日時
const targetTime = new Date(elem.getAttribute("data-target-time"));  //ターゲット日時を取得
const remainTime = targetTime.getTime() - now.getTime() ;  //差分を取る（ミリ秒で返ってくる


// 指定の日時を過ぎていたらスキップ
if(remainTime < 0) return true

// //差分の日・時・分・秒を取得
// const difYear = Math.floor(remainTime / 1000 / 60 / 60 / 24 / 365) 
const difDay = Math.floor(remainTime / 1000 / 60 / 60 / 24) 
const difHour = Math.floor(remainTime / 1000 / 60 / 60 ) % 24
const difMin = Math.floor(remainTime / 1000 / 60) % 60
const difSec = Math.floor(remainTime / 1000) % 60

// //残りの日時を上書き
// elem.querySelectorAll('.countdown-year')[0].textContent = difYear
elem.querySelectorAll('.countdown-day')[0].textContent = difDay
elem.querySelectorAll('.countdown-hour')[0].textContent = difHour
elem.querySelectorAll('.countdown-min')[0].textContent = difMin
elem.querySelectorAll('.countdown-sec')[0].textContent = difSec    
    });
    
}, 1000)    //1秒間に1度処理
//---------------------------------------------------------------------
// todo.phpトップ用日時
const thisYear = new Date().getFullYear();
const targetDate = new Date(No1time);

// 目標日時を指定（年, 月（0-11）, 日, 時, 分, 秒）
// const targetDate = new Date( 2023, 11, 1, 17, 0, 0 );
// 以下のように文字列型の日付フォーマットでもOK
// const targetDate = new Date( '2023/12/1 17:00:00' );

const ele = document.getElementById( 'countdown' );

const countdown = () => {
  const now = new Date();
  const distance = targetDate - now;

  if ( distance < 0 ) {
    ele.innerHTML = "　　ミッション失敗！";

  } else {
    const days = Math.floor( distance / ( 1000 * 60 * 60 * 24 ) );
    const hours = Math.floor( ( distance % ( 1000 * 60 * 60 * 24 ) ) / ( 1000 * 60 * 60 ) );
    const minutes = Math.floor( ( distance % ( 1000 * 60 * 60 ) ) / ( 1000 * 60 ) );
    const seconds = Math.floor( ( distance % ( 1000 * 60 ) ) / 1000 );
    const miliseconds = distance < 0 ? 0 : Math.floor( distance % 1000 );

    ele.innerHTML = `<span class="days">${ days.toLocaleString() }</span>DAY<span class="hours">${ String( hours ).padStart( 2, '0' ) }</span>H<span class="minutes">${ String( minutes ).padStart( 2, '0' ) }</span>M<span class="seconds">${ String( seconds ).padStart( 2, '0' ) }</span>.<span class="mili">${ String( miliseconds ).padStart( 3, '0' ) }</span>s`;
    window.requestAnimationFrame( countdown );
  }
}

window.requestAnimationFrame( countdown );

//編集削除ボタンのポップアップ
function Check(){
  var checked = confirm('実行しますか？');
  if(checked == true){
      return true;
  }else{
    return false;
  }
}
// //list.phpの表示順番変更の選択の分岐
const language = document.querySelector('html').lang;
if(language === 'list'){
  document.querySelector('option[value="list.php"]').selected = true;
} else if(language === 'list2'){
  document.querySelector('option[value="list2.php"]').selected = true;
}else if(language === 'list3'){
  document.querySelector('option[value="list3.php"]').selected = true;
}else if(language === 'list4'){
  document.querySelector('option[value="list4.php"]').selected = true;
}
document.getElementById('form').select.onchange = function() {
  location.href = document.getElementById('form').select.value;
}
