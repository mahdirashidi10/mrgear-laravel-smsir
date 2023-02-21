<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet"> 
<p align="center"><img src="src/resources/images/smsirlogo.png"> <img src="src/resources/images/swap2.png" width="40"> <img src="src/resources/images/laravel-logo.svg" width="40"></p>

<div style="font-family: Lalezar!important;">
<div dir="rtl">

# پکیج ارسال اس ام اس sms.ir v2 برای لاراول

[![License](https://poser.pugx.org/prettus/l5-repository/license)](https://packagist.org/packages/prettus/l5-repository)

این پکیج برای ارسال اس ام اس از طریق API پنل sms.ir ورژن ۲ در طراحی شده است.

# لیست محتوا

- [نصب](#نصب)
- [فایل کانفیگ و env.](#env)
- [طریقه استفاده](#طریقه-استفاده)
    - [متودها](#متودها)
    - [چند مثال](#چندمثال)
        - [ارسال تکی](#single)
        - [ارسال گروهی](#multiple)
        - [ارسال نظیر به نظیر](#p2p)
        - [ارسال وریفای (سریع)](#verify)

## نصب

</div>


```
composer require mrgear/laravel-smsir
```

<div dir="rtl" id="env">

## smsir.php , .env


برای تنظیم کلیدهای شماره خط، لینک پایه (base_url)، شناسه قالب پیش فرض در فایل env. از کلیدهای زیر استفاده کنید
</div>
<div dir="ltr">

```
SMSIR_BASE_URL=https://api.sms.ir/v1/send/
SMSIR_API_KEY=Your api key
SMSIR_LINE_NUMBER=Your pannel line number
SMSIR_TEMPLATE_ID=Default template id
```

</div>
<div dir="rtl">
فایل کانفیگ smsir.php شامل اطلاعات کلید api، شماره خط، لینک پایه (base_url)، شناسه قالب پیش فرض  میباشد که از فایل env. دریافت میکند.

برای تغییر فایل کانفیگ از دستور زیر استفاده کنید تا فایل Config/smsir.php درون دایرکتوری تنظیمات لاراول قرار بگیرد.

</div>

```
php artisan vendor:publish --provider=MRGear\SMSIR\Providers\SMSIRServiceProvider --tag=config
```

<div dir="rtl">

## طریقه استفاده


با استفاده از کلاس ```SMSIR``` میتوانیم پروسه ارسال اس ام اس را انجام دهیم.

### متودها

</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();

//تعیین شماره تلفن همراه بصورت تکی (برای استفاده در اسلا تکی و وریفای)
$smsir_instance->phoneNumber('09xx');

//تعیین شماره تلفن همراه بصورت گروهی (برای استفاده در ارسال نظیر به نظیر و گروهی)
$smsir_instance->phoneNumbers(['09xx' , '09xx']);

//تعیین پیام مورد نظر برای ارسال (برای در ارسال گروهی و تکی)
$smsir_instance->message(['09xx1' , '09xx2' , '09xx3']);

//تعیین پیام بصورت گروهی (برای استفاده در ارسال نظیر به نظیر)
$smsir_instance->messages(['message 1' , 'message 2' , 'message 3']);

//تعیین شناسه قالب بصورت دستی (برای استفاده در ارسال وریفای) 
$smsir_instance->templateId('123xx');
//تعیین پارامترهای ارسال وریفای بصورت دستی (برای استفاده در ارسال وریفای) 
$smsir_instance->parameters(['name' => 'VERIFICATION_CODE' , 'value' => '12345']);
// یا
$smsir_instance->parameters(['parameter_mame' , 'parameter_value']);
// یا
$smsir_instance->parameters([ 'parameter_value' , 'parameter_mame']);

// آماده سازی برای ارسال تکی
$smsir_instance->single();

// آماده سازی برای ارسال گروهی
$smsir_instance->multiple();

// آماده سازی برای ارسال نظیر به نظیر
$smsir_instance->p2p();

// آماده سازی برای ارسال وریفای
$smsir_instance->fast();

//ارسال
$smsir_instance->send();
```

<div dir="rtl">

### چند مثال

برای ارسال اس ام اس باید پارامترهای مورد نیاز و متود مورد نظر تعیین شود.

در پنل sms.ir سه روش ارسال گروهی، وریفای و نظیر به نظیر تعریف شده است که در زیر مثالی از هرکدام را بررسی میکنیم.
</div>

<div dir="rtl" id="single">

#### روش از سال تکی:

</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->message('پیام مورد نظر')->phoneNumber('09xx')->single()->send();
//یا
$smsir_instance->phoneNumber('09xx');
$smsir_instance->message('پیام مورد نظر');
$smsir_instance->single()->send();
```

<div dir="rtl" id="multiple">

#### روش از سال گروهی:

</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->message('پیام مورد نظر')->phoneNumbers(['0912xxx' , '0935xxx'])->multiple()->send();
//یا
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx']);
$smsir_instance->message('پیام مورد نظر');
$smsir_instance->multiple()->send();
```

<div dir="rtl" id="p2p">

#### روش از سال نظیر به نظیر:

</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx'])->message(['message 1' , 'message 2'])->p2p()->send();
//یا
$smsir_instance->message(['message 1' , 'message 2']);
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx']);
$smsir_instance->p2p()->send();
```

<div dir="rtl" id="verify">

#### روش از سال وریفای:

</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->parameters(['12454' , 'VERIFICATION_CODE'])->fast()->send();
//تعیین قالب بصورت دستی

$smsir_instance->templateId('123xx')->parameters(['VERIFICATION_CODE' , '12345'])->fast()->send();
```

<div dir="rtl" id="notification">

# نوتیفیکیشن

کلاس ```SMSIRNotification``` از سیستم نوتیفیکیشن لاراول بهره میبرد.

برای استفاده از سیستم نوتیفیکیشن در کلاسی که از تریت ```Notifiable``` استفاده میکند، نام فیلد شماره تلفن را باید از
طریق متغیر ```smsir_phone_number$``` ست کرد.

برای مثال اگر  مدل User را که فیلد شماره تلفن همراه با نام ```phone_number```ذخیره شده است را در نظر بگیریم، متغیر به شکل زیر خواهد بود
</div>

```php
namespace App\Models;

use Illuminate\Notifications\Notifiable;

class User  
{
    use Notifiable;
    
    public $smsir_phone_number = 'phone_number';
}
```

<div dir="rtl">
کلاس نوتیفیکیشن تنها برای استفاده از دو حالت ارسال تکی و ارسال سریع (متود وریفای) استفاده میشود.

اگر ورودی کلاس بصورت رشته باشد، سیستم نوتیفیکیشن ارسال را تکی در نظر میگیرد و ورودی به عنوان پیام ارسال خواهد شد

برای ارسال وریفای میتوان پارامترهای ارسال وریفای را بصورت ارایه به ورودی کلاس داد.

> نکته: جهت انتخاب دستی شناسه قالب میتوانید با کلید 'template_id' در آرایه‌ی ورودی، شناسه را تغییر دهید.


</div>
<div dir="rtl">

##### مثال

</div>

```php
//ارسال تکی
$notification = new \MRGear\SMSIR\Notifications\SMSIRNotification('پیام مورد نظر');

//ارسال سریع ( وریفای )
$notification = new \MRGear\SMSIR\Notifications\SMSIRNotification(['VERIFICATION_CODE' , '12345']);

//ارسال سریع (وریفای) با تعیین شناسه قالب
$notification = new \MRGear\SMSIR\Notifications\SMSIRNotification(['VERIFICATION_CODE' , '12345' , 'template_id' => '12xx']);

$user = \App\Models\User::first();
$user->notify($notification);
```

# Facade , Helper Function

<div dir="rtl">

برای دسترسی استاتیک و استفاده از قابلیت Facade لاراول میتوانید از کلاس ```MRGear\SMSIR\SMSIRFacade\ ``` استفاده کنید

متود کمکی smsir برای دسترسی به شکل زیر ایجاد شده است
</div>

```php
smsir($message , $phone_number, $data = null , $template_id = null);
```
<div dir="rtl">
برای ارسال تکی

کافیست که متغیر اول و دوم را بصورت رشته ارسال کنیم
</div>

```php
smsir('message text' , '09xx');
```
<div dir="rtl">
برای ارسال گروهی

در این حالت متغیر ```message$```  را بصورت رشته و متغیر ```phone_number$``` را بصورت آرایه‌ای از شماره‌ها ارسال می‌کنیم
</div>

```php
smsir(smsir('message text' , ['09xx' , '09xx' , '09xx']);
```
<div dir="rtl">
برای ارسال نظیر به نظیر

در این حالت متغیر ```message$```  را بصورت ارایه‌ی پیام‌ها و متغیر ```phone_number$``` را بصورت آرایه‌ای از شماره‌ها ارسال می‌کنیم

</div>

```php
smsir(['message text1' , 'message text2' , 'message text3' ] , ['09xx' , '09xx' , '09xx' ]);
```

<div dir="rtl">
برای ارسال وریفای (سریع)

در این حالت کافیست که بجای متغیر اول verify ( با حروف بزرگ یا کوچک)، یا v (کوچک یا بزرگ) ، fast (با حروف بزرگ یا کوچک) یا ```true``` جایگزاری کنیم.

>در این حالت پارامتر‌های مورد نظر بجای متغیر سوم و درصورت نیاز شناسه قالب را بصورت دستی با متغیر چهارم ارسال میکنیم

</div>

```php
smsir(true , '09x', ['VERIFICATION_CODE' , '123456']);
smsir('V' , '09x', ['VERIFICATION_CODE' , '123456'] , '12xx');
smsir('Verify' , '09x', ['123456' , 'VERIFICATION_CODE'] );
smsir('fast' , '09x', ['12456' , 'VERIFICATION_CODE'] , '12xxx');

```
</div>
