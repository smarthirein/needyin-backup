
function DWRHelper() { }
DWRHelper._path = '/dwr';

DWRHelper.afterPropertiesSet = function(callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'afterPropertiesSet', callback);
}

DWRHelper.updateRepresentationType = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'updateRepresentationType', p0, p1, callback);
}

DWRHelper.setSeoAIService = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setSeoAIService', p0, callback);
}

DWRHelper.getCandidateTargetUrl = function(callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getCandidateTargetUrl', callback);
}

DWRHelper.setCandidateTargetUrl = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setCandidateTargetUrl', p0, callback);
}

DWRHelper.getCandidateApplyUrl = function(callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getCandidateApplyUrl', callback);
}

DWRHelper.setCandidateApplyUrl = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setCandidateApplyUrl', p0, callback);
}

DWRHelper.getEmployerTargetUrl = function(callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getEmployerTargetUrl', callback);
}

DWRHelper.setEmployerTargetUrl = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setEmployerTargetUrl', p0, callback);
}

DWRHelper.setDynamicFormService = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setDynamicFormService', p0, callback);
}

DWRHelper.getDynamicJobSearchService = function(callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getDynamicJobSearchService', callback);
}

DWRHelper.setDynamicSearchService = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setDynamicSearchService', p0, callback);
}

DWRHelper.setDictionaryService = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setDictionaryService', p0, callback);
}

DWRHelper.setSeoSearchService = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'setSeoSearchService', p0, callback);
}

DWRHelper.getChildFields = function(p0, p1, p2, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getChildFields', p0, p1, p2, callback);
}

DWRHelper.getFieldsByEntityIdAndTypeIds = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getFieldsByEntityIdAndTypeIds', p0, p1, callback);
}

DWRHelper.getDictionaryItemsByTypeId = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getDictionaryItemsByTypeId', p0, callback);
}

DWRHelper.getDictionaryItemsByFieldId = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getDictionaryItemsByFieldId', p0, callback);
}

DWRHelper.getDictionaryItemsByOwnerIds = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getDictionaryItemsByOwnerIds', p0, p1, callback);
}

DWRHelper.getChildCriteria = function(p0, p1, p2, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getChildCriteria', p0, p1, p2, callback);
}

DWRHelper.getSearchDictionaryItemsByOwnerIds = function(p0, p1, p2, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getSearchDictionaryItemsByOwnerIds', p0, p1, p2, callback);
}

DWRHelper.saveState = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'saveState', p0, callback);
}

DWRHelper.saveSearchHistoryBoxState = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'saveSearchHistoryBoxState', p0, callback);
}

DWRHelper.saveHelpTipsBoxState = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'saveHelpTipsBoxState', p0, callback);
}

DWRHelper.updateURL = function(p0, p1, p2, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'updateURL', p0, p1, p2, callback);
}

DWRHelper.deleteURL = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'deleteURL', p0, callback);
}

DWRHelper.deleteSeoSearchCriterion = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'deleteSeoSearchCriterion', p0, callback);
}

DWRHelper.getSuggestedItemsByTextAndFieldId = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getSuggestedItemsByTextAndFieldId', p0, p1, callback);
}

DWRHelper.getSuggestedItemsByTextAndCriterionId = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getSuggestedItemsByTextAndCriterionId', p0, p1, callback);
}

DWRHelper.updateKeyword = function(p0, p1, p2, p3, p4, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'updateKeyword', p0, p1, p2, p3, p4, callback);
}

DWRHelper.getKeywordStatistics = function(p0, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'getKeywordStatistics', p0, callback);
}

DWRHelper.login = function(p0, p1, callback) {
    DWREngine._execute(DWRHelper._path, 'DWRHelper', 'login', p0, p1, callback);
}
