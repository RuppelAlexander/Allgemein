 <?php
 /**
  * ----------------------------------------------------------------------------
  * © ISC it & software consultants GmbH  (All rights reserved.)
  * DO NOT MODIFY THIS FILE !
  * ----------------------------------------------------------------------------
  * Author        : RuppelA
  * Create Date   : 07.07.2025
  * Change Date   : 07.07.2025
  * Main Program  : ISC_DeepL_Translator
  * Description   : manifest.php
  * ----------------------------------------------------------------------------
  * Change Log    :
  * Date        Name    Description
  * ----------------------------------------------------------------------------
  * ----------------------------------------------------------------------------
  */

 $manifest = [
     'key' => 'ISC_DeepL_Translator',
     'name' => 'ISC DeepL Translator',
     'description' => 'Adds DeepL translation features.',
     'version' => '1.0.0',
     'author' => 'Alexander Ruppel',
     'is_uninstallable' => '1',
     'published_date' => '2025-07-07',
     'type' => 'module',
	 'remove_tables' => 'prompt',
     'acceptable_sugar_versions' => array(
         'regex_matches' => [
            '10\\.*',
            '11\\.*',
            '12\\.*',
            '13\\.*',
			'14\\.*',
         ],
     ),
     'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
 ];
 

 $installdefs = [
     'id' => 'ISC_DeepL_Translator',
     'copy' => [
         // Notes: Dropdown-Eintrag im Record (Rowaction ins Menü hängen)
         [
             'from' => '<basepath>/custom/Extension/modules/Notes/Ext/clients/base/views/record/isc_pdf2de_dropdown.php',
             'to'   => 'custom/Extension/modules/Notes/Ext/clients/base/views/record/isc_pdf2de_dropdown.php',
         ],

         // Notes: Modul-Sprachdateien (Labels für Button/UX)
         [
             'from' => '<basepath>/custom/Extension/modules/Notes/Ext/Language/de_DE.isc_pdf2de.php',
             'to'   => 'custom/Extension/modules/Notes/Ext/Language/de_DE.isc_pdf2de.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/modules/Notes/Ext/Language/en_us.isc_pdf2de.php',
             'to'   => 'custom/Extension/modules/Notes/Ext/Language/en_us.isc_pdf2de.php',
         ],

         // Notes: Vardef des Relate-Feldes (Studio-fähig)
         [
             'from' => '<basepath>/custom/Extension/modules/Notes/Ext/Vardefs/sugarfield_uebersetzungs_anhang_c.php',
             'to'   => 'custom/Extension/modules/Notes/Ext/Vardefs/sugarfield_uebersetzungs_anhang_c.php',
         ],

         // Notes: Sidecar-Field "isc_pdf2de-rowaction" (Controller + Templates)
         [
             'from' => '<basepath>/custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/isc_pdf2de-rowaction.js',
             'to'   => 'custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/isc_pdf2de-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/detail.hbs',
             'to'   => 'custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/edit.hbs',
             'to'   => 'custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/list.hbs',
             'to'   => 'custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/small.hbs',
             'to'   => 'custom/modules/Notes/clients/base/fields/isc_pdf2de-rowaction/small.hbs',
         ],

       // Application language entries
         [
             'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.isc_deepl.php',
             'to' => 'custom/Extension/application/Ext/Language/de_DE.isc_deepl.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.isc_deepl.php',
             'to' => 'custom/Extension/application/Ext/Language/en_us.isc_deepl.php',
         ],

        // Administration module extensions
         [
             'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Administration/isc_deepl_admin.php',
             'to' => 'custom/Extension/modules/Administration/Ext/Administration/isc_deepl_admin.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/de_DE.ISC_DEEPL.php',
             'to' => 'custom/Extension/modules/Administration/Ext/Language/de_DE.ISC_DEEPL.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/en_us.ISC_DEEPL.php',
             'to' => 'custom/Extension/modules/Administration/Ext/Language/en_us.ISC_DEEPL.php',
         ],

       // Tasks module extensions
         [
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/de_DE.ISC_TRANSLATE_BUTTON.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Language/de_DE.ISC_TRANSLATE_BUTTON.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/en_us.ISC_TRANSLATE_BUTTON.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Language/en_us.ISC_TRANSLATE_BUTTON.php',
         ],
         /*[
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/uebersetzung_c_longtext.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/uebersetzung_c_longtext.php',
         ],*/
         [
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_uebersetzung_c.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_uebersetzung_c.php',
         ],
         [
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/clients/base/views/record/isc_translate_rowactions.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/clients/base/views/record/isc_translate_rowactions.php',
         ],

        // API entry point
         [
             'from' => '<basepath>/custom/clients/base/api/iscDeepLTranslationApi.php',
             'to' => 'custom/clients/base/api/iscDeepLTranslationApi.php',
         ],

        // Administration user interface
         [
             'from' => '<basepath>/custom/modules/Administration/clients/base/layouts/isc_deepl/isc_deepl.php',
             'to' => 'custom/modules/Administration/clients/base/layouts/isc_deepl/isc_deepl.php',
         ],
         [
             'from' => '<basepath>/custom/modules/Administration/clients/base/views/isc_deepl/isc_deepl.hbs',
             'to' => 'custom/modules/Administration/clients/base/views/isc_deepl/isc_deepl.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Administration/clients/base/views/isc_deepl/isc_deepl.js',
             'to' => 'custom/modules/Administration/clients/base/views/isc_deepl/isc_deepl.js',
         ],

        // Rowaction buttons - de2en
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/isc_translate_de2en-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/isc_translate_de2en-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2en-rowaction/small.hbs',
         ],

        // Rowaction buttons - de2fr
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/isc_translate_de2fr-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/isc_translate_de2fr-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2fr-rowaction/small.hbs',
         ],

        // Rowaction buttons - de2sp
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/isc_translate_de2sp-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/isc_translate_de2sp-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_de2sp-rowaction/small.hbs',
         ],

        // Rowaction buttons - en2de
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/isc_translate_en2de-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/isc_translate_en2de-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/small.hbs',
         ],

       // Rowaction buttons - fr2de
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/isc_translate_fr2de-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/isc_translate_fr2de-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_fr2de-rowaction/small.hbs',
         ],

       // Rowaction buttons - sp2de
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/detail.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/detail.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/edit.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/edit.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/isc_translate_sp2de-rowaction.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/isc_translate_sp2de-rowaction.js',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/list.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/list.hbs',
         ],
         [
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/small.hbs',
             'to' => 'custom/modules/Tasks/clients/base/fields/isc_translate_sp2de-rowaction/small.hbs',
         ],

       // Service class
         [
             'from' => '<basepath>/custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php',
             'to' => 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php',
         ],
     ],
     // Auto-Repair nach Installation
     'post_execute'   => ['<basepath>/scripts/post_install.php'],

 ];
