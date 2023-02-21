<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet"> 
<p align="center"><img src="resources/images/smsirlogo.png"></p>

<div style="font-family: Lalezar">
<div dir="rtl">

# پکیج ارسال اس ام اس sms.ir v2 برای لاراول



[![License](https://poser.pugx.org/prettus/l5-repository/license)](https://packagist.org/packages/prettus/l5-repository)

این پکیج برای ارسال اس ام اس از طریق API پنل sms.ir ورژن ۲  در طراحی شده است.



# لیست محتوا

- [نصب](#نصب)
- [فایل کانفیگ و env.](#env)
- [طریقه استفاده](#طریقه-استفاده)
    - [کار با صورتحساب ها](#کار-با-صورتحساب-ها)
    - [ثبت درخواست برای پرداخت صورتحساب](#ثبت-درخواست-برای-پرداخت-صورتحساب)
    - [پرداخت صورتحساب](#پرداخت-صورتحساب)
    - [اعتبار سنجی پرداخت](#اعتبار-سنجی-پرداخت)
    - [ایجاد درایور دلخواه](#ایجاد-درایور-دلخواه)
    - [متدهای سودمند](#متدهای-سودمند)
- [تغییرات](#تغییرات)
- [مشارکت کننده ها](#مشارکت-کننده-ها)
- [امنیت](#امنیت)
- [توسعه دهندگان](#توسعه-دهندگان)
- [لایسنس](#لایسنس)

# درایورهای موجود

- [اسان پرداخت](https://asanpardakht.ir/) :heavy_check_mark:
- [آتی‌پی](https://www.atipay.net/) :heavy_check_mark:
- [به‌پرداخت (mellat)](http://www.behpardakht.com/) :heavy_check_mark:
- [دیجی پی](https://www.mydigipay.com/) :heavy_check_mark:
- [ایدی پی](https://idpay.ir/) :heavy_check_mark:
- [ایرانکیش](http://irankish.com/) :heavy_check_mark:
- [نکست پی](https://nextpay.ir/) :heavy_check_mark:
- [پارسیان](https://www.pec.ir/) :heavy_check_mark:
- [پاسارگاد](https://www.bpi.ir/) :heavy_check_mark:
- [پی آی ار](https://pay.ir/) :heavy_check_mark:
- [پی پال](http://www.paypal.com/) (به زودی در ورژن بعدی اضافه میشود)
- [پی پینگ](https://www.payping.ir/) :heavy_check_mark:
- [پی استار](http://paystar.ir/) :heavy_check_mark:
- [پولام](https://poolam.ir/) :heavy_check_mark:
- [سداد (بانک ملی)](https://sadadpsp.ir/) :heavy_check_mark:
- [سامان](https://www.sep.ir) :heavy_check_mark:
- [سپهر (صادرات)](https://www.sepehrpay.com/) :heavy_check_mark:
- [یک پی](https://yekpay.com/) :heavy_check_mark:
- [زرین پال](https://www.zarinpal.com/) :heavy_check_mark:
- [زیبال](https://www.zibal.ir/) :heavy_check_mark:
- [سپرده](https://sepordeh.com/) :heavy_check_mark:
- [سیزپی](https://www.sizpay.ir/) :heavy_check_mark:

- درایورهای دیگر ساخته خواهند شد یا اینکه بسازید و درخواست `merge` بدید.

> در صورتی که درایور مورد نظرتون موجود نیست, می‌تونید برای درگاه پرداخت موردنظرتون درایور بسازید.

## نصب

---
</div>

```
composer require mrgear/laravel-smsir
```


<div dir="rtl" id="env">

## smsir.php , .env

---

برای تنظیم کلیدهای  شماره خط، لینک پایه (base_url)، شناسه قالب پیش فرض در فایل env. از کلیدهای زیر استفاده کنید
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

برای تغییر فایل کانفیگ از دستور زیر استفاده کنید  تا فایل Config/smsir.php درون دایرکتوری تنظیمات لاراول قرار بگیرد.

</div>

```
php artisan vendor:publish --provider=MRGear\SMSIR\Providers\SMSIRServiceProvider --tag=config
```

<div dir="rtl">

##  طریقه استفاده

---
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

<div dir="rtl">
 روش از سال تکی:
</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->message('پیام مورد نظر')->phoneNumber('09xx')->single()->send();
//یا
$smsir_instance->phoneNumber('09xx');
$smsir_instance->message('پیام مورد نظر');
$smsir_instance->single()->send();
```

<div dir="rtl">
روش از سال گروهی:
</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->message('پیام مورد نظر')->phoneNumbers(['0912xxx' , '0935xxx'])->multiple()->send();
//یا
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx']);
$smsir_instance->message('پیام مورد نظر');
$smsir_instance->multiple()->send();
```

<div dir="rtl">
روش از سال نظیر به نظیر:
</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx'])->message(['message 1' , 'message 2'])->p2p()->send();
//یا
$smsir_instance->message(['message 1' , 'message 2']);
$smsir_instance->phoneNumbers(['0912xxx' , '0935xxx']);
$smsir_instance->p2p()->send();
```


<div dir="rtl">
روش از سال وریفای:
</div>

```php
$smsir_instance = new \MRGear\SMSIR\SMSIR();
$smsir_instance->parameters(['12454' , 'VERIFICATION_CODE'])->fast()->send();
//تعیین قالب بصورت دستی

$smsir_instance->templateId('123xx')->parameters(['VERIFICATION_CODE' , '12345'])->fast()->send();
```

</div>