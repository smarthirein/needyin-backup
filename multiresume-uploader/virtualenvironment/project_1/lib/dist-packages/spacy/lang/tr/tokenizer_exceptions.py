# coding: utf8
from __future__ import unicode_literals

from ...symbols import ORTH, NORM

_exc = {"sağol": [{ORTH: "sağ"}, {ORTH: "ol", NORM: "olun"}]}


for exc_data in [
    {ORTH: "A.B.D.", NORM: "Amerika Birleşik Devletleri"},
    {ORTH: "Alb.", NORM: "Albay"},
    {ORTH: "Ar.Gör.", NORM: "Araştırma Görevlisi"},
    {ORTH: "Arş.Gör.", NORM: "Araştırma Görevlisi"},
    {ORTH: "Asb.", NORM: "Astsubay"},
    {ORTH: "Astsb.", NORM: "Astsubay"},
    {ORTH: "As.İz.", NORM: "Askeri İnzibat"},
    {ORTH: "Atğm", NORM: "Asteğmen"},
    {ORTH: "Av.", NORM: "Avukat"},
    {ORTH: "Apt.", NORM: "Apartmanı"},
    {ORTH: "Bçvş.", NORM: "Başçavuş"},
    {ORTH: "bk.", NORM: "bakınız"},
    {ORTH: "bknz.", NORM: "bakınız"},
    {ORTH: "Bnb.", NORM: "Binbaşı"},
    {ORTH: "bnb.", NORM: "binbaşı"},
    {ORTH: "Böl.", NORM: "Bölümü"},
    {ORTH: "Bşk.", NORM: "Başkanlığı"},
    {ORTH: "Bştbp.", NORM: "Baştabip"},
    {ORTH: "Bul.", NORM: "Bulvarı"},
    {ORTH: "Cad.", NORM: "Caddesi"},
    {ORTH: "çev.", NORM: "çeviren"},
    {ORTH: "Çvş.", NORM: "Çavuş"},
    {ORTH: "dak.", NORM: "dakika"},
    {ORTH: "dk.", NORM: "dakika"},
    {ORTH: "Doç.", NORM: "Doçent"},
    {ORTH: "doğ.", NORM: "doğum tarihi"},
    {ORTH: "drl.", NORM: "derleyen"},
    {ORTH: "Dz.", NORM: "Deniz"},
    {ORTH: "Dz.K.K.lığı", NORM: "Deniz Kuvvetleri Komutanlığı"},
    {ORTH: "Dz.Kuv.", NORM: "Deniz Kuvvetleri"},
    {ORTH: "Dz.Kuv.K.", NORM: "Deniz Kuvvetleri Komutanlığı"},
    {ORTH: "dzl.", NORM: "düzenleyen"},
    {ORTH: "Ecz.", NORM: "Eczanesi"},
    {ORTH: "ekon.", NORM: "ekonomi"},
    {ORTH: "Fak.", NORM: "Fakültesi"},
    {ORTH: "Gn.", NORM: "Genel"},
    {ORTH: "Gnkur.", NORM: "Genelkurmay"},
    {ORTH: "Gn.Kur.", NORM: "Genelkurmay"},
    {ORTH: "gr.", NORM: "gram"},
    {ORTH: "Hst.", NORM: "Hastanesi"},
    {ORTH: "Hs.Uzm.", NORM: "Hesap Uzmanı"},
    {ORTH: "huk.", NORM: "hukuk"},
    {ORTH: "Hv.", NORM: "Hava"},
    {ORTH: "Hv.K.K.lığı", NORM: "Hava Kuvvetleri Komutanlığı"},
    {ORTH: "Hv.Kuv.", NORM: "Hava Kuvvetleri"},
    {ORTH: "Hv.Kuv.K.", NORM: "Hava Kuvvetleri Komutanlığı"},
    {ORTH: "Hz.", NORM: "Hazreti"},
    {ORTH: "Hz.Öz.", NORM: "Hizmete Özel"},
    {ORTH: "İng.", NORM: "İngilizce"},
    {ORTH: "Jeol.", NORM: "Jeoloji"},
    {ORTH: "jeol.", NORM: "jeoloji"},
    {ORTH: "Korg.", NORM: "Korgeneral"},
    {ORTH: "Kur.", NORM: "Kurmay"},
    {ORTH: "Kur.Bşk.", NORM: "Kurmay Başkanı"},
    {ORTH: "Kuv.", NORM: "Kuvvetleri"},
    {ORTH: "Ltd.", NORM: "Limited"},
    {ORTH: "Mah.", NORM: "Mahallesi"},
    {ORTH: "mah.", NORM: "mahallesi"},
    {ORTH: "max.", NORM: "maksimum"},
    {ORTH: "min.", NORM: "minimum"},
    {ORTH: "Müh.", NORM: "Mühendisliği"},
    {ORTH: "müh.", NORM: "mühendisliği"},
    {ORTH: "MÖ.", NORM: "Milattan Önce"},
    {ORTH: "Onb.", NORM: "Onbaşı"},
    {ORTH: "Ord.", NORM: "Ordinaryüs"},
    {ORTH: "Org.", NORM: "Orgeneral"},
    {ORTH: "Ped.", NORM: "Pedagoji"},
    {ORTH: "Prof.", NORM: "Profesör"},
    {ORTH: "Sb.", NORM: "Subay"},
    {ORTH: "Sn.", NORM: "Sayın"},
    {ORTH: "sn.", NORM: "saniye"},
    {ORTH: "Sok.", NORM: "Sokak"},
    {ORTH: "Şb.", NORM: "Şube"},
    {ORTH: "Şti.", NORM: "Şirketi"},
    {ORTH: "Tbp.", NORM: "Tabip"},
    {ORTH: "T.C.", NORM: "Türkiye Cumhuriyeti"},
    {ORTH: "Tel.", NORM: "Telefon"},
    {ORTH: "tel.", NORM: "telefon"},
    {ORTH: "telg.", NORM: "telgraf"},
    {ORTH: "Tğm.", NORM: "Teğmen"},
    {ORTH: "tğm.", NORM: "teğmen"},
    {ORTH: "tic.", NORM: "ticaret"},
    {ORTH: "Tug.", NORM: "Tugay"},
    {ORTH: "Tuğg.", NORM: "Tuğgeneral"},
    {ORTH: "Tümg.", NORM: "Tümgeneral"},
    {ORTH: "Uzm.", NORM: "Uzman"},
    {ORTH: "Üçvş.", NORM: "Üstçavuş"},
    {ORTH: "Üni.", NORM: "Üniversitesi"},
    {ORTH: "Ütğm.", NORM: "Üsteğmen"},
    {ORTH: "vb.", NORM: "ve benzeri"},
    {ORTH: "vs.", NORM: "vesaire"},
    {ORTH: "Yard.", NORM: "Yardımcı"},
    {ORTH: "Yar.", NORM: "Yardımcı"},
    {ORTH: "Yd.Sb.", NORM: "Yedek Subay"},
    {ORTH: "Yard.Doç.", NORM: "Yardımcı Doçent"},
    {ORTH: "Yar.Doç.", NORM: "Yardımcı Doçent"},
    {ORTH: "Yb.", NORM: "Yarbay"},
    {ORTH: "Yrd.", NORM: "Yardımcı"},
    {ORTH: "Yrd.Doç.", NORM: "Yardımcı Doçent"},
    {ORTH: "Y.Müh.", NORM: "Yüksek mühendis"},
    {ORTH: "Y.Mim.", NORM: "Yüksek mimar"},
]:
    _exc[exc_data[ORTH]] = [exc_data]


for orth in ["Dr.", "yy."]:
    _exc[orth] = [{ORTH: orth}]


TOKENIZER_EXCEPTIONS = _exc