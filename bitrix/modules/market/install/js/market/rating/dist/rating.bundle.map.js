{"version":3,"file":"rating.bundle.map.js","names":["this","BX","exports","ui_vue3","market_installStore","main_popup","ui_designTokens","ui_vue3_pinia","Stars","props","methods","isActiveStar","currentStar","rating","parseInt","template","RatingItem","components","data","computed","activeReview","getReviewText","review","REVIEW_TEXT_SHORT","REVIEW_TEXT_FULL","getAnswerText","REVIEW_ANSWER_TEXT_SHORT","REVIEW_ANSWER_TEXT_FULL","mounted","setTimeout","$refs","marketReviewItem","removeAttribute","showFullReview","Main","Popup","content","marketFullReview","overlay","closeIcon","autoHide","closeByEsc","width","borderRadius","padding","className","show","POPUP_CONTAINER_PREFIX","POPUP_ID","POPUP_BORDER_RADIUS","PopupWrapper","name","emits","popupContainer","created","instance","getPopupInstance","adjustPosition","forceBindPosition","position","getConfig","bindOptions","beforeUnmount","closePopup","_PopupManager$getPopu","PopupManager","getPopupById","id","destroy","minHeight","cacheable","animation","events","onPopupClose","bind","onPopupDestroy","backgroundColor","opacity","contentBorderRadius","$emit","Rating","ratingClickState","addingReview","policyChecked","rulesChecked","feedbackBlock","reviewText","currentRating","starsError","sendingReview","canReview","appInfo","REVIEWS","CAN_REVIEW","showPolicy","SHOW_POLICY_CHECKBOX","showRules","SHOW_RULES_CHECKBOX","allChecked","appWasInstalled","WAS_INSTALLED","showInstallState","$parent","countReviews","canRatingClick","mapState","marketInstallState","marketFeedback","UI","Ears","container","smallSize","noScrollbar","init","USER_RATING","scrollToUserReview","window","scrollTo","top","getBoundingClientRect","behavior","ratingClick","currentRatingClick","addingReviewClick","nextTick","marketFeedbackText","focus","cancelAddingReviewClick","backToReviews","addReview","showNotify","$Bitrix","Loc","getMessage","ajax","runAction","appCode","CODE","analyticsLabel","then","response","success","successReviewHandler","error","errors","slice","firstError","shift","text","Notification","Center","notify","Position","BOTTOM_LEFT","getCountStars","star","RATING","RATING_DETAIL","getStarWidth","can_review","review_info","mapActions","Market","Vue3","Pinia"],"sources":["rating.bundle.js"],"mappings":"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"}