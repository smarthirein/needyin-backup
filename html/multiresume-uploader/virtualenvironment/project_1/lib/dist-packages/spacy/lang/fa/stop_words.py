# coding: utf8
from __future__ import unicode_literals


# Stop words from HAZM package
STOP_WORDS = set(
    """
و
در
به
از
که
این
را
با
است
برای
آن
یک
خود
تا
کرد
بر
هم
نیز
گفت
می‌شود
وی
شد
دارد
ما
اما
یا
شده
باید
هر
آنها
بود
او
دیگر
دو
مورد
می‌کند
شود
کند
وجود
بین
پیش
شده‌است
پس
نظر
اگر
همه
یکی
حال
هستند
من
کنند
نیست
باشد
چه
بی
می
بخش
می‌کنند
همین
افزود
هایی
دارند
راه
همچنین
روی
داد
بیشتر
بسیار
سه
داشت
چند
سوی
تنها
هیچ
میان
اینکه
شدن
بعد
جدید
ولی
حتی
کردن
برخی
کردند
می‌دهد
اول
نه
کرده‌است
نسبت
بیش
شما
چنین
طور
افراد
تمام
درباره
بار
بسیاری
می‌تواند
کرده
چون
ندارد
دوم
بزرگ
طی
حدود
همان
بدون
البته
آنان
می‌گوید
دیگری
خواهد‌شد
کنیم
قابل
یعنی
رشد
می‌توان
وارد
کل
ویژه
قبل
براساس
نیاز
گذاری
هنوز
لازم
سازی
بوده‌است
چرا
می‌شوند
وقتی
گرفت
کم
جای
حالی
تغییر
پیدا
اکنون
تحت
باعث
مدت
فقط
زیادی
تعداد
آیا
بیان
رو
شدند
عدم
کرده‌اند
بودن
نوع
بلکه
جاری
دهد
برابر
مهم
بوده
اخیر
مربوط
امر
زیر
گیری
شاید
خصوص
آقای
اثر
کننده
بودند
فکر
کنار
اولین
سوم
سایر
کنید
ضمن
مانند
باز
می‌گیرد
ممکن
حل
دارای
پی
مثل
می‌رسد
اجرا
دور
منظور
کسی
موجب
طول
امکان
آنچه
تعیین
گفته
شوند
جمع
خیلی
علاوه
گونه
تاکنون
رسید
ساله
گرفته
شده‌اند
علت
چهار
داشته‌باشد
خواهد‌بود
طرف
تهیه
تبدیل
مناسب
زیرا
مشخص
می‌توانند
نزدیک
جریان
روند
بنابراین
می‌دهند
یافت
نخستین
بالا
پنج
ریزی
عالی
چیزی
نخست
بیشتری
ترتیب
شده‌بود
خاص
خوبی
خوب
شروع
فرد
کامل
غیر
می‌رود
دهند
آخرین
دادن
جدی
بهترین
شامل
گیرد
بخشی
باشند
تمامی
بهتر
داده‌است
حد
نبود
کسانی
می‌کرد
داریم
علیه
می‌باشد
دانست
ناشی
داشتند
دهه
می‌شد
ایشان
آنجا
گرفته‌است
دچار
می‌آید
لحاظ
آنکه
داده
بعضی
هستیم
اند
برداری
نباید
می‌کنیم
نشست
سهم
همیشه
آمد
اش
وگو
می‌کنم
حداقل
طبق
جا
خواهد‌کرد
نوعی
چگونه
رفت
هنگام
فوق
روش
ندارند
سعی
بندی
شمار
کلی
کافی
مواجه
همچنان
زیاد
سمت
کوچک
داشته‌است
چیز
پشت
آورد
حالا
روبه
سال‌های
دادند
می‌کردند
عهده
نیمه
جایی
دیگران
سی
بروز
یکدیگر
آمده‌است
جز
کنم
سپس
کنندگان
خودش
همواره
یافته
شان
صرف
نمی‌شود
رسیدن
چهارم
یابد
متر
ساز
داشته
کرده‌بود
باره
نحوه
کردم
تو
شخصی
داشته‌باشند
محسوب
پخش
کمی
متفاوت
سراسر
کاملا
داشتن
نظیر
آمده
گروهی
فردی
ع
همچون
خطر
خویش
کدام
دسته
سبب
عین
آوری
متاسفانه
بیرون
دار
ابتدا
شش
افرادی
می‌گویند
سالهای
درون
نیستند
یافته‌است
پر
خاطرنشان
گاه
جمعی
اغلب
دوباره
می‌یابد
لذا
زاده
گردد
اینجا""".split()
)