<?php

namespace app\code;

/**
 * Description of FeatureType
 *
 * @author tranduc-quy
 */
class FeatureType {
    /** 顔認識 */
    const FACE_DETECTION = 'FACE_DETECTION';
    /** ランドマークの認識 */
    const LANDMARK_DETECTION = 'LANDMARK_DETECTION';    
    /** 製品ロゴの認識 */
    const LOGO_DETECTION = 'LOGO_DETECTION';
    /** 画像コンテンツの認識 (ラベリング) */
    const LABEL_DETECTION = 'LABEL_DETECTION';
    /** 画像内テキストの認識 (OCR) */
    const TEXT_DETECTION = 'TEXT_DETECTION';
    /** SAFE_SEARCH_DETECTION */
    const SAFE_SEARCH_DETECTION = 'SAFE_SEARCH_DETECTION';    
}
