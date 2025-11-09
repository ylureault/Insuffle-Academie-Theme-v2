<?php
/**
 * Styles pour la page d'édition de fiche
 */
if (!defined('ABSPATH')) exit;
?>

<style>
.ffm-edit-wrap {
    margin: 20px 20px 0 0;
}

.ffm-edit-wrap h1 {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ffm-edit-wrap h1 .dashicons {
    font-size: 32px;
    width: 32px;
    height: 32px;
    color: #8E2183;
}

.ffm-form-container {
    max-width: 1200px;
}

/* Sections */
.ffm-section {
    background: white;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.ffm-section h2 {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #8E2183;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f1;
}

.ffm-section h2 .dashicons {
    font-size: 24px;
    width: 24px;
    height: 24px;
}

/* Fields */
.ffm-field {
    margin-bottom: 20px;
}

.ffm-field label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
}

.ffm-field input[type="text"],
.ffm-field textarea {
    width: 100%;
    max-width: 600px;
}

.ffm-field .description {
    margin-top: 5px;
    font-size: 13px;
    color: #666;
}

/* Photo Upload */
.ffm-photo-upload {
    text-align: center;
}

.ffm-photo-preview {
    margin-bottom: 20px;
}

.ffm-photo-preview img {
    max-width: 280px;
    height: auto;
    border-radius: 50%;
    border: 8px solid #FFD466;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.ffm-no-photo {
    width: 280px;
    height: 280px;
    margin: 0 auto;
    background: #f0f0f1;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
}

.ffm-no-photo .dashicons {
    font-size: 80px;
    width: 80px;
    height: 80px;
}

/* Stats */
#ffm-stats-list {
    margin-bottom: 20px;
}

.ffm-stat-item {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    display: flex;
    transition: all 0.3s;
}

.ffm-stat-item:hover {
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.ffm-stat-handle {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 15px;
    cursor: move;
    background: #f0f0f0;
    border-right: 1px solid #ddd;
    border-radius: 8px 0 0 8px;
}

.ffm-stat-handle .dashicons {
    font-size: 24px;
    color: #999;
}

.ffm-stat-content {
    flex: 1;
    padding: 20px;
}

.ffm-stat-fields {
    display: grid;
    grid-template-columns: 150px 1fr auto;
    gap: 15px;
    align-items: end;
}

.ffm-field-number label,
.ffm-field-label label {
    font-size: 13px;
    margin-bottom: 5px;
}

.ffm-stat-number-input,
.ffm-stat-label-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.ffm-stat-remove-wrap {
    padding-bottom: 8px;
}

.ffm-remove-stat {
    color: #b32d2e;
}

.ffm-add-stat-wrap {
    text-align: center;
    margin: 20px 0;
}

/* Help */
.ffm-help {
    background: #e7f3ff;
    border-left: 4px solid #0073aa;
    padding: 15px 20px;
    margin-top: 20px;
}

.ffm-help ul {
    margin: 10px 0 0 20px;
}

/* Submit */
.ffm-submit-wrap {
    background: #f0f0f1;
    padding: 20px;
    margin-top: 30px;
    border-top: 1px solid #c3c4c7;
    text-align: center;
}

.ffm-submit-wrap .button {
    margin: 0 10px;
}

/* Sortable */
.ffm-sortable-placeholder {
    background: #FFD466;
    border: 2px dashed #8E2183;
    border-radius: 8px;
    height: 80px;
    margin-bottom: 15px;
}
</style>
