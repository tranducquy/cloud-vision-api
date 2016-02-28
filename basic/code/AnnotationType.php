<?php
namespace app\code;

use \app\code\FeatureType;

/**
 * Description of AnnotationType
 *
 * @author tranduc-quy
 */
class AnnotationType {
    
    const FACE_ANNOTATION = "faceAnnotations";
    const LANDMARK_ANNOTATION = "landmarkAnnotations";
    const LOGO_ANNOTATION = "logoAnnotations";
    const LABEL_ANNOTATION = "labelAnnotations";
    const TEXT_ANNOTATION = "textAnnotations";
    const SAFE_SEARCH_ANNOTATION = "safeSearchAnnotation";
    
    /**
     * 
     * @param type $feature_type
     * @return string
     */
    public static function getAnnotation($feature_type) {
        switch ($feature_type) {
            case FeatureType::FACE_DETECTION:
                return self::FACE_ANNOTATION;
            case FeatureType::LANDMARK_DETECTION:
                return self::LANDMARK_ANNOTATION;
            case FeatureType::LOGO_DETECTION:
                return self::LOGO_ANNOTATION;
            case FeatureType::LABEL_DETECTION:
                return self::LABEL_ANNOTATION;
            case FeatureType::TEXT_DETECTION:
                return self::TEXT_ANNOTATION;
            case FeatureType::SAFE_SEARCH_DETECTION:
                return self::SAFE_SEARCH_ANNOTATION;
            default:
                return 'errors';          
        }
    }
}
