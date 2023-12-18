# coding: utf8
from __future__ import unicode_literals

_exc = {
    # Regional words normal
    # Sri Lanka - wikipeadia
    "இங்க": "இங்கே",
    "வாங்க": "வாருங்கள்",
    "ஒண்டு": "ஒன்று",
    "கண்டு": "கன்று",
    "கொண்டு": "கொன்று",
    "பண்டி": "பன்றி",
    "பச்ச": "பச்சை",
    "அம்பது": "ஐம்பது",
    "வெச்ச": "வைத்து",
    "வச்ச": "வைத்து",
    "வச்சி": "வைத்து",
    "வாளைப்பழம்": "வாழைப்பழம்",
    "மண்ணு": "மண்",
    "பொன்னு": "பொன்",
    "சாவல்": "சேவல்",
    "அங்கால": "அங்கு ",
    "அசுப்பு": "நடமாட்டம்",
    "எழுவான் கரை": "எழுவான்கரை",
    "ஓய்யாரம்": "எழில் ",
    "ஒளும்பு": "எழும்பு",
    "ஓர்மை": "துணிவு",
    "கச்சை": "கோவணம்",
    "கடப்பு": "தெருவாசல்",
    "சுள்ளி": "காய்ந்த குச்சி",
    "திறாவுதல்": "தடவுதல்",
    "நாசமறுப்பு": "தொல்லை",
    "பரிசாரி": "வைத்தியன்",
    "பறவாதி": "பேராசைக்காரன்",
    "பிசினி": "உலோபி ",
    "விசர்": "பைத்தியம்",
    "ஏனம்": "பாத்திரம்",
    "ஏலா": "இயலாது",
    "ஒசில்": "அழகு",
    "ஒள்ளுப்பம்": "கொஞ்சம்",
    # Srilankan and indian
    "குத்துமதிப்பு": "",
    "நூனாயம்": "நூல்நயம்",
    "பைய": "மெதுவாக",
    "மண்டை": "தலை",
    "வெள்ளனே": "சீக்கிரம்",
    "உசுப்பு": "எழுப்பு",
    "ஆணம்": "குழம்பு",
    "உறக்கம்": "தூக்கம்",
    "பஸ்": "பேருந்து",
    "களவு": "திருட்டு ",
    # relationship
    "புருசன்": "கணவன்",
    "பொஞ்சாதி": "மனைவி",
    "புள்ள": "பிள்ளை",
    "பிள்ள": "பிள்ளை",
    "ஆம்பிளப்புள்ள": "ஆண் பிள்ளை",
    "பொம்பிளப்புள்ள": "பெண் பிள்ளை",
    "அண்ணாச்சி": "அண்ணா",
    "அக்காச்சி": "அக்கா",
    "தங்கச்சி": "தங்கை",
    # difference words
    "பொடியன்": "சிறுவன்",
    "பொட்டை": "சிறுமி",
    "பிறகு": "பின்பு",
    "டக்கென்டு": "விரைவாக",
    "கெதியா": "விரைவாக",
    "கிறுகி": "திரும்பி",
    "போயித்து வாறன்": "போய் வருகிறேன்",
    "வருவாங்களா": "வருவார்களா",
    # regular spokens
    "சொல்லு": "சொல்",
    "கேளு": "கேள்",
    "சொல்லுங்க": "சொல்லுங்கள்",
    "கேளுங்க": "கேளுங்கள்",
    "நீங்கள்": "நீ",
    "உன்": "உன்னுடைய",
    # Portugeese formal words
    "அலவாங்கு": "கடப்பாரை",
    "ஆசுப்பத்திரி": "மருத்துவமனை",
    "உரோதை": "சில்லு",
    "கடுதாசி": "கடிதம்",
    "கதிரை": "நாற்காலி",
    "குசினி": "அடுக்களை",
    "கோப்பை": "கிண்ணம்",
    "சப்பாத்து": "காலணி",
    "தாச்சி": "இரும்புச் சட்டி",
    "துவாய்": "துவாலை",
    "தவறணை": "மதுக்கடை",
    "பீப்பா": "மரத்தாழி",
    "யன்னல்": "சாளரம்",
    "வாங்கு": "மரஇருக்கை",
    # Dutch formal words
    "இறாக்கை": "பற்சட்டம்",
    "இலாட்சி": "இழுப்பறை",
    "கந்தோர்": "பணிமனை",
    "நொத்தாரிசு": "ஆவண எழுத்துபதிவாளர்",
    # English formal words
    "இஞ்சினியர்": "பொறியியலாளர்",
    "சூப்பு": "ரசம்",
    "செக்": "காசோலை",
    "சேட்டு": "மேற்ச்சட்டை",
    "மார்க்கட்டு": "சந்தை",
    "விண்ணன்": "கெட்டிக்காரன்",
    # Arabic formal words
    "ஈமான்": "நம்பிக்கை",
    "சுன்னத்து": "விருத்தசேதனம்",
    "செய்த்தான்": "பிசாசு",
    "மவுத்து": "இறப்பு",
    "ஹலால்": "அங்கீகரிக்கப்பட்டது",
    "கறாம்": "நிராகரிக்கப்பட்டது",
    # Persian, Hindustanian and hindi formal words
    "சுமார்": "கிட்டத்தட்ட",
    "சிப்பாய்": "போர்வீரன்",
    "சிபார்சு": "சிபாரிசு",
    "ஜமீன்": "பணக்காரா்",
    "அசல்": "மெய்யான",
    "அந்தஸ்து": "கௌரவம்",
    "ஆஜர்": "சமா்ப்பித்தல்",
    "உசார்": "எச்சரிக்கை",
    "அச்சா": "நல்ல",
    # English words used in text conversations
    "bcoz": "ஏனெனில்",
    "bcuz": "ஏனெனில்",
    "fav": "விருப்பமான",
    "morning": "காலை வணக்கம்",
    "gdeveng": "மாலை வணக்கம்",
    "gdnyt": "இரவு வணக்கம்",
    "gdnit": "இரவு வணக்கம்",
    "plz": "தயவு செய்து",
    "pls": "தயவு செய்து",
    "thx": "நன்றி",
    "thanx": "நன்றி",
}

NORM_EXCEPTIONS = {}

for string, norm in _exc.items():
    NORM_EXCEPTIONS[string] = norm
