<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitProvider;
use App\Models\DOSTEmployee;

class DOSTEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $units = UnitProvider::pluck('id', 'unit_name')->all();

        $employees = [
            // ORD Employees
            ['name' => 'Virginia G. Bilgera', 'employee_id' => 'VGB-0111-055', 'unit_provider' => 'ORD'],
            ['name' => 'Marielle T. Pagulayan', 'employee_id' => 'MTP-0709-238', 'unit_provider' => 'ORD'],
            ['name' => 'Raquel B. Santos', 'employee_id' => 'RBS-0825-139', 'unit_provider' => 'ORD'],
            ['name' => 'Geraldine R. Cruz', 'employee_id' => 'GRC-1019-019', 'unit_provider' => 'ORD'],
            ['name' => 'Ana B. Duldulao', 'employee_id' => 'ABD-0129-234', 'unit_provider' => 'ORD'],
            ['name' => 'Marco Antonio L. Conseja', 'employee_id' => 'MLC-1219-231', 'unit_provider' => 'ORD'],
            ['name' => 'Benedict P. Tumaliuan', 'employee_id' => 'BPT-0115-210', 'unit_provider' => 'ORD'],
            ['name' => 'Victor B. Perlas Jr.', 'employee_id' => 'VBP-0907-249', 'unit_provider' => 'ORD'],

            // FASS Employees
            ['name' => 'Mary Ann P. Maglasin', 'employee_id' => 'MPM-0625-010', 'unit_provider' => 'FASS'],
            ['name' => 'Nancy C. Guimmayen', 'employee_id' => 'NCG-1206-012', 'unit_provider' => 'Scholarship'],
            ['name' => 'Claudence Joyce V. Batang', 'employee_id' => 'CVB-0102-015', 'unit_provider' => 'Scholarship'],
            ['name' => 'Micah M. Taguba', 'employee_id' => 'MMT-0505-164', 'unit_provider' => 'Scholarship'],
            ['name' => 'Junivie M. Langcay', 'employee_id' => 'JML-0125-050', 'unit_provider' => 'Scholarship'],
            ['name' => 'Rolex B. Tolentino', 'employee_id' => 'RBT-0610-145', 'unit_provider' => 'Scholarship'],
            ['name' => 'Nelson P. Olea', 'employee_id' => 'NPO-1115-003', 'unit_provider' => 'Scholarship'],
            ['name' => 'Cecilia S. Calagui', 'employee_id' => 'CSC-1222-024', 'unit_provider' => 'Scholarship'],
            ['name' => 'Angelica G. Tuddao', 'employee_id' => 'AGT-1022-247', 'unit_provider' => 'Scholarship'],
            ['name' => 'Madelyn P. Bulaqui', 'employee_id' => 'MPB-1212-160', 'unit_provider' => 'Scholarship'],
            ['name' => 'Luzviminda B. Bucayu', 'employee_id' => 'LBB-0314-014', 'unit_provider' => 'Scholarship'],
            ['name' => 'Ma. Angelica C. Adduru', 'employee_id' => 'MCA-0903-110', 'unit_provider' => 'Scholarship'],
            ['name' => 'Rico A. Adduru', 'employee_id' => 'RBA-0615-029', 'unit_provider' => 'Scholarship'],
            ['name' => 'Ramil M. Tangan', 'employee_id' => 'RMT-0506-129', 'unit_provider' => 'Scholarship'],
            ['name' => 'Ronald C. Fabroa', 'employee_id' => 'RCG-1116-258', 'unit_provider' => 'Scholarship'],
            ['name' => 'Cherielyn A. Gregorio', 'employee_id' => 'CAG-1027-257', 'unit_provider' => 'Scholarship'],
            ['name' => 'Kris Andrew P. Evanculla', 'employee_id' => 'KPE-0910-253', 'unit_provider' => 'Scholarship'],

            // TOS Employees
            ['name' => 'Laila A. Taguinod', 'employee_id' => 'LAT-0303-248', 'unit_provider' => 'TOS'],
            ['name' => 'Mary Ann D. Carpiso', 'employee_id' => 'MDC-0517-246', 'unit_provider' => 'SETUP'],
            ['name' => 'Aileen C. Gonzales', 'employee_id' => 'ACG-0721-033', 'unit_provider' => 'SETUP'],
            ['name' => 'Rowena A. Guzman', 'employee_id' => 'RAG-1207-017', 'unit_provider' => 'SETUP'],
            ['name' => 'Jude Michael C. Magora', 'employee_id' => 'JCM-0429-189', 'unit_provider' => 'SETUP'],
            ['name' => 'Duane M. Carodan', 'employee_id' => 'DMC-0722-217', 'unit_provider' => 'SETUP'],
            ['name' => 'Jeremiah J. Orpilla', 'employee_id' => 'JJO-0105-250', 'unit_provider' => 'SETUP'],
            ['name' => 'Joy C. Albino', 'employee_id' => 'JCA-0128-218', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Jeffson B. Carbonell', 'employee_id' => 'JBC-0825-243', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Carl Joshua D. Reyes', 'employee_id' => 'CDR-1105-236', 'unit_provider' => 'Startbook'],
            ['name' => 'Angelo Caranguian', 'employee_id' => 'AC-0408-233', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Ferdinand Michael B. Magusib', 'employee_id' => 'FBM-1227-007', 'unit_provider' => 'RML'],
            ['name' => 'Jamaica Beverly G. Calagui', 'employee_id' => 'JGC-0106-178', 'unit_provider' => 'RSTL'],
            ['name' => 'Jhon David A. Villanueva', 'employee_id' => 'JAV-0319-225', 'unit_provider' => 'RML'],
            ['name' => 'Samantha H. Baliza', 'employee_id' => 'SHB-0102-227', 'unit_provider' => 'RSTL'],
            ['name' => 'Glydel G. Pascua', 'employee_id' => 'GGP-0108-192', 'unit_provider' => 'RSTL'],
            ['name' => 'Neil P. Dela Cruz', 'employee_id' => 'NPD-0912-214', 'unit_provider' => 'RSTL'],
            ['name' => 'Amazing Grace U. De La Cruz', 'employee_id' => 'AUD-0120-223', 'unit_provider' => 'RML'],
            ['name' => 'Alijah Samuel V. Mabborang', 'employee_id' => 'AVM-0122-237', 'unit_provider' => 'RSTL'],
            ['name' => 'Marlon M. Arao', 'employee_id' => 'MMA-0809-136', 'unit_provider' => 'RSTL'],
            ['name' => 'Jhon Joe T. Garcia', 'employee_id' => 'JTG-0115-256', 'unit_provider' => 'RML'],
            ['name' => 'Niko S. Tabangin', 'employee_id' => 'NST-0721-221', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Rodora B. Santos', 'employee_id' => 'RBS-1216-206', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Jenny-Rose G. Masocol', 'employee_id' => 'JGM-0812-196', 'unit_provider' => 'S&T Information and Promotion'],
            ['name' => 'Aileen C. Gonzales', 'employee_id' => 'ACG-0721-033', 'unit_provider' => 'SETUP'],

            // PSTO Batanes Employees
            ['name' => 'Nora T. Garcia', 'employee_id' => 'NTG-1127-200', 'unit_provider' => 'PSTO Batanes'],
            ['name' => 'Araceli G. Puño', 'employee_id' => 'AGP-0123-242', 'unit_provider' => 'PSTO Batanes'],
            ['name' => 'Mark Keneth C. Sumbillo', 'employee_id' => 'MCS-0915-240', 'unit_provider' => 'PSTO Batanes'],
            ['name' => 'Joy Ann M. Horlina', 'employee_id' => 'JMH-0417-131', 'unit_provider' => 'PSTO Batanes'],
            ['name' => 'Mitchel Raymund B. Luchega', 'employee_id' => 'MBL-0831-132', 'unit_provider' => 'PSTO Batanes'],
            ['name' => 'Charmaine Irenea P. Tagarino', 'employee_id' => 'CPT-1011-241', 'unit_provider' => 'PSTO Batanes'],

            // PSTO Cagayan Employees
            ['name' => 'Sylvia T. Lacambra', 'employee_id' => 'STL-0308-004', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Jayferson D. Mabborang', 'employee_id' => 'JDM-1123-043', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Benjamin L. Nicdao II', 'employee_id' => 'BLN-0719-008', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Romeo A. Puyat', 'employee_id' => 'RAP-0222-069', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Elise Marie M. Lucas', 'employee_id' => 'EML-1117-096', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Ezekiel V. Reyes', 'employee_id' => 'EVR-1013-235', 'unit_provider' => 'PSTO Cagayan'],
            ['name' => 'Reynald T. Eclipse', 'employee_id' => 'RTE-0723-255', 'unit_provider' => 'PSTO Cagayan'],

            // PSTO Isabela Employees
            ['name' => 'Rosario G. Danga', 'employee_id' => 'RGD-1009-245', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Lucio G. Calimag', 'employee_id' => 'LGC-0525-123', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Rogelio J. Bulusan Jr.', 'employee_id' => 'RJB-1213-006', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'James S. Respondo', 'employee_id' => 'JSR-0806-072', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Patrick C. Cristobal', 'employee_id' => 'PCC-0620-127', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Angelo V. Capurian', 'employee_id' => 'AVC-1215-174', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Anzon F. Babaran', 'employee_id' => 'AFP-1127-153', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Christian Calimag', 'employee_id' => 'CCC-1127-224', 'unit_provider' => 'PSTO Isabela'],
            ['name' => 'Nicole Mae T. Domingo', 'employee_id' => 'NTD-0103-251', 'unit_provider' => 'PSTO Isabela'],

            // PSTO Quirino Employees
            ['name' => 'Rocela Angelica B. Gorospe', 'employee_id' => 'RBG-1213-044', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Victoria B. Mabborang', 'employee_id' => 'VBM-1009-020', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Daisy D.J. Simon', 'employee_id' => 'DDS-0404-120', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Lhea V. Seculles', 'employee_id' => 'LVS-0919-122', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Villamor P. Quilang', 'employee_id' => 'VPQ-0422-116', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Jonathan A. De Jesus', 'employee_id' => 'JAD-0811-177', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Nelson C. Calimag', 'employee_id' => 'NCC-0214-124', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Rizaldy C. Teñoso', 'employee_id' => 'RCT-0619-239', 'unit_provider' => 'PSTO Quirino'],
            ['name' => 'Ricky S. Macalan', 'employee_id' => 'RSM-0401-254', 'unit_provider' => 'PSTO Quirino'],

            // PSTO Nueva Vizcaya Employees
            ['name' => 'Jonathan D.R. Nuestro', 'employee_id' => 'JRN-1202-118', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Mark Gil S. Hizon', 'employee_id' => 'MSH-0307-060', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Rommel N. Simbol', 'employee_id' => 'RNS-0710-105', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Florita D. Sinot', 'employee_id' => 'FDS-0410-112', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Rowena G. Da-ang', 'employee_id' => 'RGD-1214-111', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Clarenet J. Balderas', 'employee_id' => 'CJB-0825-126', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Lhea Lee C. Galap', 'employee_id' => 'LCG-0404-177', 'unit_provider' => 'PSTO Nueva Vizcaya'],
            ['name' => 'Dominique P. Medina', 'employee_id' => 'DPM-1014-252', 'unit_provider' => 'PSTO Nueva Vizcaya'],
        ];

        foreach ($employees as $employee) {
            $unitId = $units[$employee['unit_provider']] ?? null;

            if (!$unitId) {
                echo "❌ Unit '{$employee['unit_provider']}' not found. Skipping {$employee['name']}.\n";
                continue;
            }

            DOSTEmployee::updateOrCreate(
                ['employee_id' => $employee['employee_id']],
                [
                    'name' => $employee['name'],
                    'unit_provider_id' => $unitId,
                    'status' => 'Active',
                ]
            );
        }

        echo "✅ DOST Employees Seeded Successfully!\n";
    }
}
