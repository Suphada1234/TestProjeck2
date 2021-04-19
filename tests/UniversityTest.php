<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class University extends TestCase{
    use TestCaseTrait;

    static private $pdo = null;
    private $conn = null;

    final public function getConnection(){
        if($this->conn === null){
            if(self::$pdo == null){
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }
        return $this->conn;
    }

    public function getDataSet(){
        return $this->createFlatXmlDataSet('./tests/university_fixture.xml');
    }

    public function testRowCount() {
        $this->assertSame(2, $this->getConnection()->getRowCount('university'), "Pre-Condition");
    }
 
    public function testAdduniversity() {
 
        $university = new University();
        $university->addUniversity(
            "มหาวิทยาลัยศรีนครินทรวิโรฒ" , 
            "www.swu.ac.th" , 
            "ชื่อย่อ	มศว / SWU
            คติพจน์	สิกฺขา วิรุฬฺหิ สมฺปตฺตา
            การศึกษา คือ ความเจริญงอกงาม
            Education is Growth
            สถาปนา	28 เมษายน พ.ศ. 2492 (71 ปี)
            ประเภท	สถาบันอุดมศึกษาในกำกับของรัฐ
            อธิการบดี	รองศาสตราจารย์ ดร.สมชาย สันติวัฒนกุล
            นายกสภาฯ	ศาสตราจารย์ ดร.เกษม สุวรรณกุล
            จำนวนผู้ศึกษา	23,600 (ปีการศึกษา 2560)
            ที่ตั้ง	• มหาวิทยาลัยศรีนครินทรวิโรฒ ประสานมิตร เลขที่ 114 ซอยสุขุมวิท 23 ถนนสุขุมวิท แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร 10110
                • มหาวิทยาลัยศรีนครินทรวิโรฒ องครักษ์ เลขที่ 107 หมู่ที่ 6 ถนนรังสิต–นครนายก ตำบลองครักษ์ อำเภอองครักษ์ จังหวัดนครนายก 26120");
 
        $queryTable = $this->getConnection()->createQueryTable('education_service', 'SELECT id_university, name_uni, url_uni, detail_uni FROM university');
 
        $expectedTable = $this->createFlatXmlDataSet("./tests/university_expected.xml")->getTable("university");
 
        $this->assertTablesEqual($expectedTable, $queryTable);
 
    }

}