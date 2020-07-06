<?php

use Illuminate\Database\Seeder;
use App\Facility;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S1','1','レーザー　三菱電機','5036D-N3',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S2','2','ボール盤　日立工機','B23SC',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S4','3','シャーリング　関西鉄工所','GS',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S6','4','ラクソー　日本工機','L-300',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S7','5','MAG用直流 半自動溶接機　松下電器産業 (350A)','YD-350HP',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S8','5','TIG 溶接機　松下電器産業（350A)','YC-300TWSP-4',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S9','5','TIG 溶接機　松下溶接システム（300A）','YC-300BZ3',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S10','5','MAG用直流 半自動溶接機　松下溶接システム（350A)','YD-350GE2',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S11','5','小形交流アーク溶接機　DAIDEN（300A)','BS300L',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S12','5','TIG 溶接機　松下電器産業(300A,交直)','YC-300WP4',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S13','5','MAG用直流 溶接機　松下溶接システム','YD-350GE2',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S14','5','MAG用直流 半自動溶接機　松下電器産業（350A)','YM-300C-3',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S15','5','MAG用直流 半自動溶接機　松下電器産業','YD-350HP',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S16','5','アーク溶接機　松下電器産業','YK-40　F-3',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S20','5','TIG 溶接機（500A）ダイヘン　交直','AEP-500(S1)',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S21','5','TIG 溶接機（500A）松下電器産業','YC500-TSP',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S22','5','TIG 溶接機（500A）ダイヘン','AVP-500(S2)',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S23','5','半自動CO2溶接機（350A)松下電器産業','YD-356-KEC',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S24','5','TIG 溶接機（300A)松下電器産業','YC-300-TWS',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S25','5','TIG 溶接機（300A)松下電器産業','YM-300C-3',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S26','5','不明　アーク溶接（150Aぐらい）','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S27','5','エアプラズマ松下電器産業','YP・060P-5',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S28','2','ボール盤　吉田鉄工所','TUD-540',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S29','13','3本ローラーMOEIMITU','',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S31','5','半自動CO2溶接機（350A）　PANA STAR AAⅡ350　松下電器産業','YD-350AA2',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S32','5','半自動CO2溶接機（200A)PANA STAR RFⅡ　200松下電器産業','',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S33','5','半自動CO2溶接機（200A)PANA STAR RFⅡ　200松下電器産業','',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S34','1','レーザー加工機　三菱電機','ML3015-HV2R-45CFR',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S35','6','レーザーバリ取り機　BurrtoL SB-050','SB-050',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S36','2','ボール盤　KIRA　','KRT-420P',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('S37','5','Panasonicインバーター制御交直両用TIG溶接用電源（300A)','〇',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P1','7','150t油圧プレス　','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P2','7','200ｔ油圧プレス　','HFP2005',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P3','13','熱処理炉　','BF-144',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P4','13','ショット　','',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P5','8','ノコ盤　AMADA','HA400',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P6','7','35ｔプレス　WASHINO','PUX35（緑）',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P7','7','35ｔプレス　WASHINO','PUX35（青）',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P8','9','30tブレーキプレス　AMADA','SPH-30',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P10','13','メタルソー　','KCM-370 ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P11','13','平面研削盤','SGW-63',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P12','9','80ｔブレーキプレス　AMADA','RG80S',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P13','7','1000tプレス　HPM','5656',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P14','7','450ｔプレス　川崎油工','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P15','7','45tプレス　AMADA','TP45X',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P16','7','60ｔプレス　AMADA','SPH-60 ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P17','7','150プレス　AMADA','TORC-PAC150',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P19','9','35tブレーキプレス　AMADA','RG35S',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('P20','9','125tプレスブレーキ　コマツ産機','ＰＢＺ-1253-2',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K1','10','NC旋盤　森精機','AL-2A',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K2','10','正面旋盤　津田','TFL-1600',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K3','10','9尺旋盤　中部工機','CLL-1500',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K4','10','7尺旋盤　中部工機','CLL-1000',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K5','10','12尺旋盤　森精機','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K6','10','6尺旋盤　池貝','AM-20',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K7','10','単能旋盤　FUJI','F-S',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K8','10','5尺旋盤　森精機','MS 650',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K11','10','6尺旋盤　森精機','MS850',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K12','10','6尺旋盤　ヤマザキ','860',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K13','10','単能旋盤　TOYOOKA','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K14','10','単能旋盤　TOYOOKA','不明',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K17','2','ボール盤　KIRA','KRTG-420',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K18','2','ボール盤　KIRA','KRTG-420',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K19','11','フライス　大隈豊和機械','STM2R',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K20','12','ラジアルボール盤　大隈鉄工所','RD15',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K21','10','NC旋盤　オークマ','　LB4000EXⅡ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('K22','12','立形マシニングセンタ　オークマ','MILLAC561VⅡ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ23','11','汎用フライス　山崎技研','ＹＺ-8Ｌ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ24','12','立形マシニングセンタ　オークマ','MB-56VA',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ25','10','NC旋盤　オークマ','LB2000EX',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ26','11','横フライス　ＯＫＫ','ＭＨ3-Ｐ',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ28','12','5軸門型MC','MPJ-2640',now(),now());");
        DB::insert("insert into facilities (code,category_id,name,model_number,created_at,updated_at) values ('Ｋ29','11','NCフライス　静岡','AN-SRN',now(),now());");
    }
}
