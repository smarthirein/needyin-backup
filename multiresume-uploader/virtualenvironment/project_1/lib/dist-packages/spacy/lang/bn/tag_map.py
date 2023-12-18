# coding: utf8
from __future__ import unicode_literals

from ...symbols import POS, PUNCT, ADJ, CONJ, SCONJ, NUM, DET, ADV, ADP, X, VERB
from ...symbols import CCONJ, NOUN, PROPN, PART, INTJ, SPACE, PRON, AUX, SYM


TAG_MAP = {
    ".": {POS: PUNCT, "PunctType": "peri"},
    ",": {POS: PUNCT, "PunctType": "comm"},
    "-LRB-": {POS: PUNCT, "PunctType": "brck", "PunctSide": "ini"},
    "-RRB-": {POS: PUNCT, "PunctType": "brck", "PunctSide": "fin"},
    "``": {POS: PUNCT, "PunctType": "quot", "PunctSide": "ini"},
    '""': {POS: PUNCT, "PunctType": "quot", "PunctSide": "fin"},
    "''": {POS: PUNCT, "PunctType": "quot", "PunctSide": "fin"},
    ":": {POS: PUNCT},
    "৳": {POS: SYM, "Other": {"SymType": "currency"}},
    "#": {POS: SYM, "Other": {"SymType": "numbersign"}},
    "AFX": {POS: ADJ, "Hyph": "yes"},
    "CC": {POS: CONJ, "ConjType": "coor"},
    "CD": {POS: NUM, "NumType": "card"},
    "DT": {POS: DET},
    "EX": {POS: ADV, "AdvType": "ex"},
    "FW": {POS: X, "Foreign": "yes"},
    "HYPH": {POS: PUNCT, "PunctType": "dash"},
    "IN": {POS: ADP},
    "JJ": {POS: ADJ, "Degree": "pos"},
    "JJR": {POS: ADJ, "Degree": "comp"},
    "JJS": {POS: ADJ, "Degree": "sup"},
    "LS": {POS: PUNCT, "NumType": "ord"},
    "MD": {POS: VERB, "VerbType": "mod"},
    "NIL": {POS: ""},
    "NN": {POS: NOUN, "Number": "sing"},
    "NNP": {POS: PROPN, "NounType": "prop", "Number": "sing"},
    "NNPS": {POS: PROPN, "NounType": "prop", "Number": "plur"},
    "NNS": {POS: NOUN, "Number": "plur"},
    "PDT": {POS: ADJ, "AdjType": "pdt", "PronType": "prn"},
    "POS": {POS: PART, "Poss": "yes"},
    "PRP": {POS: PRON, "PronType": "prs"},
    "PRP$": {POS: ADJ, "PronType": "prs", "Poss": "yes"},
    "RB": {POS: ADV, "Degree": "pos"},
    "RBR": {POS: ADV, "Degree": "comp"},
    "RBS": {POS: ADV, "Degree": "sup"},
    "RP": {POS: PART},
    "TO": {POS: PART, "PartType": "inf", "VerbForm": "inf"},
    "UH": {POS: INTJ},
    "VB": {POS: VERB, "VerbForm": "inf"},
    "VBD": {POS: VERB, "VerbForm": "fin", "Tense": "past"},
    "VBG": {POS: VERB, "VerbForm": "part", "Tense": "pres", "Aspect": "prog"},
    "VBN": {POS: VERB, "VerbForm": "part", "Tense": "past", "Aspect": "perf"},
    "VBP": {POS: VERB, "VerbForm": "fin", "Tense": "pres"},
    "VBZ": {
        POS: VERB,
        "VerbForm": "fin",
        "Tense": "pres",
        "Number": "sing",
        "Person": 3,
    },
    "WDT": {POS: ADJ, "PronType": "int|rel"},
    "WP": {POS: NOUN, "PronType": "int|rel"},
    "WP$": {POS: ADJ, "Poss": "yes", "PronType": "int|rel"},
    "WRB": {POS: ADV, "PronType": "int|rel"},
    "SP": {POS: SPACE},
    "ADV": {POS: ADV},
    "NOUN": {POS: NOUN},
    "ADP": {POS: ADP},
    "PRON": {POS: PRON},
    "SCONJ": {POS: SCONJ},
    "PROPN": {POS: PROPN},
    "DET": {POS: DET},
    "SYM": {POS: SYM},
    "INTJ": {POS: INTJ},
    "PUNCT": {POS: PUNCT},
    "NUM": {POS: NUM},
    "AUX": {POS: AUX},
    "X": {POS: X},
    "CONJ": {POS: CONJ},
    "CCONJ": {POS: CCONJ},
    "ADJ": {POS: ADJ},
    "VERB": {POS: VERB},
    "PART": {POS: PART},
}
